<?php

namespace App\Http\Controllers;

use App\Models\KategoriKeuangan;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class KeuanganController extends Controller
{
    /**
     * Daftar transaksi kas beserta ringkasan saldo.
     */
    public function index(Request $request): View
    {
        $keuangans = Keuangan::with('kategoriKeuangan')
            ->when($request->filled('tipe'), fn ($query) => $query->where('tipe', $request->input('tipe')))
            ->when($request->filled('kategori_keuangan_id'), fn ($query) => $query->where('kategori_keuangan_id', $request->input('kategori_keuangan_id')))
            ->when($request->filled('bulan'), function ($query) use ($request) {
                $bulan = Carbon::parse($request->input('bulan'));
                $query->whereYear('tanggal', $bulan->year)->whereMonth('tanggal', $bulan->month);
            })
            ->latest('tanggal')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $kategoris = KategoriKeuangan::orderBy('nama')->get();

        $bulanIni = now();
        $pemasukanBulanIni = Keuangan::where('tipe', 'pemasukan')
            ->whereMonth('tanggal', $bulanIni->month)
            ->whereYear('tanggal', $bulanIni->year)
            ->sum('nominal');

        $pengeluaranBulanIni = Keuangan::where('tipe', 'pengeluaran')
            ->whereMonth('tanggal', $bulanIni->month)
            ->whereYear('tanggal', $bulanIni->year)
            ->sum('nominal');

        $saldo = Keuangan::selectRaw("SUM(CASE WHEN tipe = 'pemasukan' THEN nominal ELSE 0 END) - SUM(CASE WHEN tipe = 'pengeluaran' THEN nominal ELSE 0 END) as saldo")->value('saldo') ?? 0;

        return view('keuangan.index', compact('keuangans', 'kategoris', 'pemasukanBulanIni', 'pengeluaranBulanIni', 'saldo'));
    }

    public function create(): View
    {
        $kategoris = KategoriKeuangan::orderBy('nama')->get();

        return view('keuangan.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori_keuangan_id' => 'required|exists:kategori_keuangans,id',
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|integer|min:0',
            'tipe' => 'required|in:pemasukan,pengeluaran',
        ]);

        $validated['user_id'] = auth()->id();

        Keuangan::create($validated);

        return redirect()->route('keuangan.index')->with('success', 'Transaksi kas berhasil dicatat.');
    }

    public function edit(Keuangan $keuangan): View
    {
        $kategoris = KategoriKeuangan::orderBy('nama')->get();

        return view('keuangan.edit', compact('keuangan', 'kategoris'));
    }

    public function update(Request $request, Keuangan $keuangan)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori_keuangan_id' => 'required|exists:kategori_keuangans,id',
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|integer|min:0',
            'tipe' => 'required|in:pemasukan,pengeluaran',
        ]);

        $keuangan->update($validated);

        return redirect()->route('keuangan.index')->with('success', 'Transaksi kas berhasil diperbarui.');
    }

    public function destroy(Keuangan $keuangan)
    {
        $keuangan->delete();

        return redirect()->route('keuangan.index')->with('success', 'Transaksi kas berhasil dihapus.');
    }
}
