<?php

namespace App\Http\Controllers;

use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriKeuanganController extends Controller
{
    public function index(): View
    {
        $kategoris = KategoriKeuangan::withCount('keuangans')->orderBy('tipe')->orderBy('nama')->paginate(15);

        return view('kategori-keuangan.index', compact('kategoris'));
    }

    public function create(): View
    {
        return view('kategori-keuangan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:pemasukan,pengeluaran',
            'keterangan' => 'nullable|string',
        ]);

        KategoriKeuangan::create($validated);

        return redirect()->route('kategori-keuangan.index')->with('success', 'Kategori keuangan berhasil ditambahkan.');
    }

    public function edit(KategoriKeuangan $kategoriKeuangan): View
    {
        return view('kategori-keuangan.edit', compact('kategoriKeuangan'));
    }

    public function update(Request $request, KategoriKeuangan $kategoriKeuangan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:pemasukan,pengeluaran',
            'keterangan' => 'nullable|string',
        ]);

        $kategoriKeuangan->update($validated);

        return redirect()->route('kategori-keuangan.index')->with('success', 'Kategori keuangan berhasil diperbarui.');
    }

    public function destroy(KategoriKeuangan $kategoriKeuangan)
    {
        if ($kategoriKeuangan->keuangans()->exists()) {
            return redirect()->route('kategori-keuangan.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih dipakai pada transaksi kas.');
        }

        $kategoriKeuangan->delete();

        return redirect()->route('kategori-keuangan.index')->with('success', 'Kategori keuangan berhasil dihapus.');
    }
}
