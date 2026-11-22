<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\Keuangan;
use App\Models\Pengumuman;
use App\Models\Surat;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan ringkasan statistik sistem RT/RW.
     */
    public function index(): View|RedirectResponse
    {
        if (auth()->check() && auth()->user()->isWarga()) {
            return redirect()->route('portal.index');
        }

        $totalWarga = Warga::count();
        $totalLaki = Warga::where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = Warga::where('jenis_kelamin', 'Perempuan')->count();
        $totalKK = Warga::where('status_perkawinan', 'Kawin')->count();

        $bulanIni = now();
        $iuranBulanIni = Iuran::where('periode', $bulanIni->format('Y-m'))
            ->where('status', 'Lunas')
            ->sum('jumlah');

        $saldo = Keuangan::query()
            ->selectRaw("SUM(CASE WHEN tipe = 'pemasukan' THEN nominal ELSE 0 END) - SUM(CASE WHEN tipe = 'pengeluaran' THEN nominal ELSE 0 END) as saldo")
            ->value('saldo') ?? 0;

        $tunggakan = Iuran::where('status', '!=', 'Lunas')->sum('jumlah');

        $suratTerbaru = Surat::with('warga')->latest()->take(5)->get();

        $agenda = Pengumuman::whereNotNull('tanggal_mulai')
            ->whereDate('tanggal_mulai', '>=', today())
            ->orderBy('tanggal_mulai')
            ->take(3)
            ->get();

        $chart = $this->cashflowChart();
        $demografi = ['laki' => $totalLaki, 'perempuan' => $totalPerempuan];

        $periodeIuran = $bulanIni->format('Y-m');

        $pendingWargaList = User::query()
            ->where('role', 'warga')
            ->whereDoesntHave('warga')
            ->get();

        $statusIuran = Warga::with(['iurans' => fn ($query) => $query->where('periode', $periodeIuran)])
            ->orderBy('nama_lengkap')
            ->get()
            ->map(function (Warga $warga): object {
                $iuran = $warga->iurans->first();

                return (object) [
                    'warga' => $warga,
                    'iuran' => $iuran,
                    'status' => $iuran->status ?? 'Belum Lunas',
                ];
            })
            ->sortBy(fn (object $row): array => [$row->status === 'Lunas' ? 1 : 0, $row->warga->nama_lengkap])
            ->values();

        foreach ($pendingWargaList as $pending) {
            $statusIuran->push((object) [
                'warga' => $pending,
                'iuran' => null,
                'status' => 'Belum Lunas',
            ]);
        }

        $statusIuran = $statusIuran
            ->sortBy(fn (object $row): array => [$row->status !== 'Lunas', ($row->warga->nama_lengkap ?? $row->warga->name)])
            ->values();

        $iuranLunas = $statusIuran->where('status', 'Lunas')->count();
        $iuranSebagian = $statusIuran->where('status', 'Sebagian')->count();
        $iuranBelum = $totalWarga - $iuranLunas - $iuranSebagian;
        $persenLunas = $totalWarga > 0 ? (int) round($iuranLunas / $totalWarga * 100) : 0;
        $tunggakanBulanIni = Iuran::where('periode', $periodeIuran)
            ->where('status', '!=', 'Lunas')
            ->sum('jumlah');

        return view('dashboard.index', compact(
            'totalWarga',
            'totalLaki',
            'totalPerempuan',
            'totalKK',
            'iuranBulanIni',
            'saldo',
            'tunggakan',
            'suratTerbaru',
            'agenda',
            'chart',
            'demografi',
            'periodeIuran',
            'statusIuran',
            'iuranLunas',
            'iuranSebagian',
            'iuranBelum',
            'persenLunas',
            'tunggakanBulanIni',
        ));
    }

    /**
     * Susun data arus kas enam bulan terakhir.
     *
     * @return array{labels: array<int, string>, pemasukan: array<int, int>, pengeluaran: array<int, int>}
     */
    private function cashflowChart(): array
    {
        $labels = [];
        $pemasukan = [];
        $pengeluaran = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->startOfMonth()->subMonths($i);
            $labels[] = $month->locale('id')->translatedFormat('M');

            $pemasukan[] = (int) Keuangan::where('tipe', 'pemasukan')
                ->whereYear('tanggal', $month->year)
                ->whereMonth('tanggal', $month->month)
                ->sum('nominal');

            $pengeluaran[] = (int) Keuangan::where('tipe', 'pengeluaran')
                ->whereYear('tanggal', $month->year)
                ->whereMonth('tanggal', $month->month)
                ->sum('nominal');
        }

        return [
            'labels' => $labels,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
        ];
    }
}
