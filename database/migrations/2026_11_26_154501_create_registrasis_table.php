<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registrasis', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi')->unique();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
            $table->foreignId('jadwal_dokter_id')->nullable()->constrained('jadwal_dokters')->onDelete('set null');
            $table->date('tanggal_kunjungan');
            $table->time('jam_kunjungan');
            $table->text('keluhan')->nullable();
            $table->enum('jenis_kunjungan', ['baru', 'kontrol'])->default('baru');
            $table->enum('status', ['menunggu', 'dipanggil', 'selesai', 'batal'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasis');
    }
};
