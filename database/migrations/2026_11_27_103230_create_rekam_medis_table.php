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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->string('record_number')->unique();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
            $table->date('tanggal_kunjungan');
            $table->string('klinik')->nullable();
            $table->text('keluhan_utama');
            $table->string('tekanan_darah')->nullable();
            $table->decimal('suhu_badan', 4, 1)->nullable();
            $table->integer('nadi')->nullable();
            $table->integer('pernapasan')->nullable();
            $table->decimal('berat_badan', 5, 1)->nullable();
            $table->decimal('tinggi_badan', 5, 1)->nullable();
            $table->decimal('bmi', 4, 1)->nullable();
            $table->integer('saturasi_oksigen')->nullable();
            $table->string('diagnosa_code')->nullable();
            $table->text('diagnosa');
            $table->text('rencana_tindakan')->nullable();
            $table->json('resep_obat')->nullable();
            $table->text('hasil_lab')->nullable();
            $table->text('catatan_dokter')->nullable();
            $table->enum('status', ['draft', 'completed', 'reviewed'])->default('completed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
