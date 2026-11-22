<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumumen';

    protected $fillable = [
        'judul',
        'kategori',
        'isi',
        'tanggal_mulai',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'is_publik',
        'user_id',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'is_publik' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
