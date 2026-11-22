<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Surat extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_surat',
        'warga_id',
        'jenis_surat',
        'keperluan',
        'status',
        'tanggal_pengajuan',
        'tanggal_disetujui',
        'ditandatangani_oleh',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_disetujui' => 'date',
    ];

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class);
    }

    /**
     * Buat nomor surat berurutan yang belum terpakai.
     */
    public static function generateNomor(): string
    {
        $year = now()->format('Y');
        $sequence = static::whereYear('created_at', $year)->count() + 1;

        do {
            $number = sprintf('470/%03d/RT05/%s', $sequence, $year);
            $sequence++;
        } while (static::where('no_surat', $number)->exists());

        return $number;
    }
}
