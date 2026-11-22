<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Iuran extends Model
{
    use HasFactory;

    /**
     * Nominal iuran default saat menandai lunas tanpa data sebelumnya.
     */
    public const DEFAULT_JUMLAH = 100000;

    protected $fillable = [
        'warga_id',
        'periode',
        'jumlah',
        'status',
        'tanggal_bayar',
        'user_id',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'tanggal_bayar' => 'date',
    ];

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
