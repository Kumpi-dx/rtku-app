<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuratController extends Controller
{
    /**
     * Daftar permohonan surat dengan filter status.
     */
    public function index(Request $request): View
    {
        $surats = Surat::with('warga')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status')))
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = $request->string('q')->toString();
                $query->where(function ($sub) use ($keyword) {
                    $sub->where('no_surat', 'like', "%{$keyword}%")
                        ->orWhere('jenis_surat', 'like', "%{$keyword}%")
                        ->orWhereHas('warga', fn ($w) => $w->where('nama_lengkap', 'like', "%{$keyword}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('surat.index', compact('surats'));
    }

    public function create(): View
    {
        $wargas = Warga::orderBy('nama_lengkap')->get();

        return view('surat.create', compact('wargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'jenis_surat' => 'required|string|max:255',
            'keperluan' => 'required|string',
        ]);

        $validated['no_surat'] = Surat::generateNomor();
        $validated['tanggal_pengajuan'] = now();
        $validated['status'] = 'Pending';

        Surat::create($validated);

        return redirect()->route('surat.index')->with('success', 'Permohonan surat berhasil diajukan.');
    }

    public function show(Surat $surat): View
    {
        $surat->load('warga');

        return view('surat.show', compact('surat'));
    }

    public function edit(Surat $surat): View
    {
        $wargas = Warga::orderBy('nama_lengkap')->get();

        return view('surat.edit', compact('surat', 'wargas'));
    }

    public function update(Request $request, Surat $surat)
    {
        $validated = $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'jenis_surat' => 'required|string|max:255',
            'keperluan' => 'required|string',
            'status' => 'required|in:Pending,Diproses,Disetujui,Ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $this->applyApproval($surat, $validated);

        $surat->update($validated);

        return redirect()->route('surat.index')->with('success', 'Data surat berhasil diperbarui.');
    }

    /**
     * Perbarui status surat dari halaman detail.
     */
    public function updateStatus(Request $request, Surat $surat)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Diproses,Disetujui,Ditolak',
            'keterangan' => 'nullable|string',
        ]);

        $this->applyApproval($surat, $validated);

        $surat->update($validated);

        return redirect()->route('surat.show', $surat)->with('success', 'Status surat berhasil diperbarui.');
    }

    public function destroy(Surat $surat)
    {
        $surat->delete();

        return redirect()->route('surat.index')->with('success', 'Data surat berhasil dihapus.');
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    private function applyApproval(Surat $surat, array &$validated): void
    {
        if (($validated['status'] ?? null) === 'Disetujui' && $surat->status !== 'Disetujui') {
            $validated['tanggal_disetujui'] = now();
            $validated['ditandatangani_oleh'] = auth()->user()?->name ?? 'Ketua RT';
        }

        if (($validated['status'] ?? null) !== 'Disetujui') {
            $validated['tanggal_disetujui'] = null;
            $validated['ditandatangani_oleh'] = null;
        }
    }
}
