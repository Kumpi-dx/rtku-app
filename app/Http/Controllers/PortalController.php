<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\Pengumuman;
use App\Models\Surat;
use App\Models\Warga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class PortalController extends Controller
{
    /**
     * Beranda portal warga.
     */
    public function index(): View
    {
        $warga = $this->currentWarga();
        $periodeIni = now()->format('Y-m');

        $iuranBulanIni = Iuran::where('warga_id', $warga->id)
            ->where('periode', $periodeIni)
            ->first();

        $tunggakan = Iuran::where('warga_id', $warga->id)
            ->where('status', '!=', 'Lunas')
            ->sum('jumlah');

        $surats = Surat::where('warga_id', $warga->id)->latest()->take(3)->get();

        $pengumumans = Pengumuman::where('is_publik', true)->latest()->take(3)->get();

        $agendas = $this->upcomingAgenda();

        return view('portal.index', compact('warga', 'iuranBulanIni', 'tunggakan', 'surats', 'pengumumans', 'agendas'));
    }

    /**
     * Form pelengkapan data kewargaan untuk akun warga lama.
     */
    public function lengkapi(): View|RedirectResponse
    {
        if (auth()->user()->warga()->exists()) {
            return redirect()->route('portal.index');
        }

        return view('portal.lengkapi');
    }

    /**
     * Simpan data kewargaan yang dilengkapi sendiri oleh warga.
     */
    public function simpanLengkapi(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->warga()->exists()) {
            return redirect()->route('portal.index');
        }

        $validated = $request->validate([
            'nik' => ['required', 'digits:16', 'unique:wargas,nik'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'status_domisili' => ['required', 'in:Tetap,Kontrak,Pindah'],
            'status_perkawinan' => ['nullable', 'in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati'],
        ]);

        Warga::create([
            ...$validated,
            'user_id' => $user->id,
        ]);

        $user->update(['name' => $validated['nama_lengkap']]);

        return redirect()->route('portal.index')->with('success', 'Data kewargaan berhasil dilengkapi.');
    }

    /**
     * Profil warga dan form pembaruan data.
     */
    public function profil(): View
    {
        $warga = $this->currentWarga();

        return view('portal.profil', compact('warga'));
    }

    /**
     * Perbarui data kontak warga dan (opsional) kata sandi.
     */
    public function updateProfil(Request $request): RedirectResponse
    {
        $warga = $this->currentWarga();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'no_telp' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $user = $request->user();
        $user->name = $validated['name'];

        if (! blank($validated['password'] ?? null)) {
            $user->password = $validated['password'];
        }

        $user->save();

        $warga->update([
            'nama_lengkap' => $validated['name'],
            'no_telp' => $validated['no_telp'] ?? null,
            'pekerjaan' => $validated['pekerjaan'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
        ]);

        return redirect()->route('portal.profil')->with('success', 'Data profil berhasil diperbarui.');
    }

    /**
     * Riwayat iuran milik warga.
     */
    public function iuran(): View
    {
        $warga = $this->currentWarga();

        $iurans = Iuran::where('warga_id', $warga->id)
            ->orderByDesc('periode')
            ->paginate(12);

        $totalLunas = Iuran::where('warga_id', $warga->id)->where('status', 'Lunas')->sum('jumlah');
        $totalTunggakan = Iuran::where('warga_id', $warga->id)->where('status', '!=', 'Lunas')->sum('jumlah');

        return view('portal.iuran', compact('warga', 'iurans', 'totalLunas', 'totalTunggakan'));
    }

    /**
     * Daftar surat milik warga.
     */
    public function surat(): View
    {
        $warga = $this->currentWarga();

        $surats = Surat::where('warga_id', $warga->id)->latest()->paginate(10);

        return view('portal.surat.index', compact('warga', 'surats'));
    }

    /**
     * Form pengajuan surat baru.
     */
    public function suratCreate(): View
    {
        $warga = $this->currentWarga();

        return view('portal.surat.create', compact('warga'));
    }

    /**
     * Simpan pengajuan surat baru oleh warga.
     */
    public function suratStore(Request $request): RedirectResponse
    {
        $warga = $this->currentWarga();

        $validated = $request->validate([
            'jenis_surat' => 'required|string|max:255',
            'keperluan' => 'required|string|max:1000',
        ]);

        Surat::create([
            'no_surat' => Surat::generateNomor(),
            'warga_id' => $warga->id,
            'jenis_surat' => $validated['jenis_surat'],
            'keperluan' => $validated['keperluan'],
            'status' => 'Pending',
            'tanggal_pengajuan' => now(),
        ]);

        return redirect()->route('portal.surat')->with('success', 'Permohonan surat berhasil dikirim. Mohon tunggu persetujuan pengurus.');
    }

    /**
     * Detail surat milik warga.
     */
    public function suratShow(Surat $surat): View
    {
        $warga = $this->currentWarga();

        abort_unless($surat->warga_id === $warga->id, 403);

        $surat->load('warga');

        return view('portal.surat.show', compact('warga', 'surat'));
    }

    /**
     * Daftar pengumuman publik.
     */
    public function pengumuman(): View
    {
        $warga = $this->currentWarga();

        $pengumumans = Pengumuman::where('is_publik', true)->latest()->paginate(9);

        return view('portal.pengumuman.index', compact('warga', 'pengumumans'));
    }

    /**
     * Detail pengumuman publik.
     */
    public function pengumumanShow(Pengumuman $pengumuman): View
    {
        $warga = $this->currentWarga();

        abort_unless($pengumuman->is_publik, 404);

        return view('portal.pengumuman.show', compact('warga', 'pengumuman'));
    }

    /**
     * Agenda kegiatan mendatang.
     */
    public function agenda(): View
    {
        $warga = $this->currentWarga();

        $agendas = $this->upcomingAgenda(20);

        return view('portal.agenda', compact('warga', 'agendas'));
    }

    private function currentWarga(): Warga
    {
        $warga = auth()->user()->warga;

        if ($warga === null) {
            abort(403, 'Akun Anda belum tertaut dengan data warga. Silakan hubungi pengurus RT.');
        }

        return $warga;
    }

    /**
     * @return Collection<int, Pengumuman>
     */
    private function upcomingAgenda(int $limit = 3)
    {
        return Pengumuman::where('is_publik', true)
            ->whereNotNull('tanggal_mulai')
            ->whereDate('tanggal_mulai', '>=', today())
            ->orderBy('tanggal_mulai')
            ->take($limit)
            ->get();
    }
}
