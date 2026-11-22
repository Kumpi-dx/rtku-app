<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class WargaController extends Controller
{
    /**
     * Daftar warga dengan pencarian dan filter.
     */
    public function index(Request $request): View
    {
        $wargas = Warga::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = $request->string('q')->toString();
                $query->where(function ($sub) use ($keyword) {
                    $sub->where('nama_lengkap', 'like', "%{$keyword}%")
                        ->orWhere('nik', 'like', "%{$keyword}%");
                });
            })
            ->when($request->filled('jenis_kelamin'), fn ($query) => $query->where('jenis_kelamin', $request->input('jenis_kelamin')))
            ->when($request->filled('status_perkawinan'), fn ($query) => $query->where('status_perkawinan', $request->input('status_perkawinan')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $pendingWarga = User::query()
            ->where('role', 'warga')
            ->whereDoesntHave('warga')
            ->latest()
            ->limit(10)
            ->get();

        $totalPendingWarga = User::query()
            ->where('role', 'warga')
            ->whereDoesntHave('warga')
            ->count();

        return view('warga.index', compact('wargas', 'pendingWarga', 'totalPendingWarga'));
    }

    public function create(): View
    {
        return view('warga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|digits:16|unique:wargas,nik',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telp' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'status_domisili' => 'required|in:Tetap,Kontrak,Pindah',
            'status_perkawinan' => 'nullable|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
        ]);

        Warga::create($validated);

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil ditambahkan.');
    }

    public function show(Warga $warga): View
    {
        $warga->load(['surats', 'iurans']);

        return view('warga.show', compact('warga'));
    }

    public function edit(Warga $warga): View
    {
        return view('warga.edit', compact('warga'));
    }

    public function update(Request $request, Warga $warga)
    {
        $validated = $request->validate([
            'nik' => 'required|digits:16|unique:wargas,nik,'.$warga->id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telp' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'status_domisili' => 'required|in:Tetap,Kontrak,Pindah',
            'status_perkawinan' => 'nullable|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
        ]);

        $warga->update($validated);

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil dihapus.');
    }

    /**
     * Ekspor seluruh data warga ke berkas CSV.
     */
    public function export(): StreamedResponse
    {
        $filename = 'data-warga-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['NIK', 'Nama Lengkap', 'Jenis Kelamin', 'No. Telp', 'Pekerjaan', 'Alamat', 'Status Domisili', 'Status Perkawinan']);

            Warga::query()->orderBy('nama_lengkap')->chunk(200, function ($wargas) use ($handle) {
                foreach ($wargas as $warga) {
                    fputcsv($handle, [
                        $warga->nik,
                        $warga->nama_lengkap,
                        $warga->jenis_kelamin,
                        $warga->no_telp,
                        $warga->pekerjaan,
                        $warga->alamat,
                        $warga->status_domisili,
                        $warga->status_perkawinan,
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
