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
        Schema::create('verifikasi_perizinans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('perizinan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('superadmin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status_admin', ['pending','disetujui','ditolak'])->default('pending');
            $table->enum('status_superadmin', ['pending','disetujui','ditolak'])->default('pending');
            $table->datetime('admin_verified_at')->nullable();
            $table->datetime('superadmin_verified_at')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->text('catatan_superadmin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasi_perizinans');
    }
};
