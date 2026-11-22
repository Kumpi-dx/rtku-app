<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iurans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained()->cascadeOnDelete();
            $table->string('periode', 7); // YYYY-MM
            $table->bigInteger('jumlah');
            $table->enum('status', ['Belum Lunas', 'Lunas', 'Sebagian'])->default('Belum Lunas');
            $table->date('tanggal_bayar')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->unique(['warga_id', 'periode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iurans');
    }
};
