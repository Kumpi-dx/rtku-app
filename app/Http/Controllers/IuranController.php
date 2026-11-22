<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\Warga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class IuranController extends Controller
{
    public function index(Request $request): View
    {
        $iurans = Iuran::with('warga')
            ->when($request->filled('warga_id'), fn ($query) => $query->where('warga_id', $request->input('warga_id')))
            ->when($request->filled('periode'), fn ($query) => $query->where('periode', $request->input('periode')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status')))
            ->latest('periode')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $wargas = Warga::orderBy('nama_lengkap')->get();

        $totalTagihan = Iuran::sum('jumlah');
        $totalLunas = Iuran::where('status', 'Lunas')->sum('jumlah');
        $totalTunggakan = Iuran::where('status', '!=', 'Lunas')->sum('jumlah');

        return view('iuran.index', compact('iurans', 'wargas', 'totalTagihan', 'totalLunas', 'totalTunggakan'));
    }

    public function create(): View
    {
        $wargas = Warga::orderBy('nama_lengkap')->get();

        return view('iuran.create', compact('wargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'periode' => [
                'required',
                'date_format:Y-m',
                Rule::unique('iurans', 'periode')
                    ->where(fn ($query) => $query->where('warga_id', $request->input('warga_id'))),
            ],
            'jumlah' => 'required|integer|min:0',
            'status' => 'required|in:Belum Lunas,Lunas,Sebagian',
            'tanggal_bayar' => 'nullable|date',
        ], [
            'periode.unique' => 'Iuran untuk warga dan periode ini sudah ada.',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['tanggal_bayar'] = $validated['status'] === 'Belum Lunas' ? null : ($validated['tanggal_bayar'] ?? now());

        Iuran::create($validated);

        return redirect()->route('iuran.index')->with('success', 'Data iuran berhasil ditambahkan.');
    }

    public function edit(Iuran $iuran): View
    {
        $wargas = Warga::orderBy('nama_lengkap')->get();

        return view('iuran.edit', compact('iuran', 'wargas'));
    }

    public function update(Request $request, Iuran $iuran)
    {
        $validated = $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'periode' => [
                'required',
                'date_format:Y-m',
                Rule::unique('iurans', 'periode')
                    ->where(fn ($query) => $query->where('warga_id', $request->input('warga_id')))
                    ->ignore($iuran->id),
            ],
            'jumlah' => 'required|integer|min:0',
            'status' => 'required|in:Belum Lunas,Lunas,Sebagian',
            'tanggal_bayar' => 'nullable|date',
        ], [
            'periode.unique' => 'Iuran untuk warga dan periode ini sudah ada.',
        ]);

        $validated['tanggal_bayar'] = $validated['status'] === 'Belum Lunas' ? null : ($validated['tanggal_bayar'] ?? now());

        $iuran->update($validated);

        return redirect()->route('iuran.index')->with('success', 'Data iuran berhasil diperbarui.');
    }

    public function destroy(Iuran $iuran)
    {
        $iuran->delete();

        return redirect()->route('iuran.index')->with('success', 'Data iuran berhasil dihapus.');
    }

    /**
     * Tandai iuran warga pada suatu periode sebagai lunas.
     */
    public function markLunas(Request $request, Warga $warga): RedirectResponse
    {
        $validated = $request->validate([
            'periode' => ['nullable', 'date_format:Y-m'],
        ]);

        $periode = $validated['periode'] ?? now()->format('Y-m');

        $iuran = Iuran::firstOrNew([
            'warga_id' => $warga->id,
            'periode' => $periode,
        ]);

        $iuran->jumlah = $iuran->jumlah ?: Iuran::DEFAULT_JUMLAH;
        $iuran->status = 'Lunas';
        $iuran->tanggal_bayar = now();
        $iuran->user_id = auth()->id();
        $iuran->save();

        return back()->with('success', "Iuran {$warga->nama_lengkap} periode {$periode} ditandai lunas.");
    }
}
