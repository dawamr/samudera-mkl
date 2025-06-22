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
        Schema::create('mkls', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 20)->index();
            $table->string('nama_pribadi', 100)->index();
            $table->string('nama_mkl', 100)->index();
            $table->string('nama_pt_mkl', 100)->index();
            $table->string('no_telepon_pribadi', 20)->nullable();
            $table->string('no_telepon_kantor', 20)->nullable();
            $table->string('email_kantor', 100)->nullable();
            $table->string('npwp_kantor', 100)->nullable();
            $table->enum('menggunakan_mtki_payment', ['Ya', 'Tidak'])->default('Tidak');
            $table->string('alasan_tidak_menggunakan_mtki_payment', 200)->nullable()->default('Tidak');
            $table->enum('status_aktif', ['Ya', 'Tidak'])->default('Ya');
            $table->string('file_ktp', 100)->nullable();
            $table->string('file_npwp', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mkls');
    }
};
