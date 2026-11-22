<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat')->unique();
            $table->foreignId('warga_id')->constrained()->cascadeOnDelete();
            $table->string('jenis_surat');
            $table->text('keperluan');
            $table->enum('status', ['Pending', 'Diproses', 'Disetujui', 'Ditolak'])->default('Pending');
            $table->date('tanggal_pengajuan')->default(now());
            $table->date('tanggal_disetujui')->nullable();
            $table->string('ditandatangani_oleh')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
