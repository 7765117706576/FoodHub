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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pembeli')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_kurir')->nullable()->constrained('kurirs')->onDelete('set null');
            $table->dateTime('tanggal_pesanan')->useCurrent();
            $table->string('status')->default('pending'); // pending, diproses, dikirim, selesai
            $table->integer('total_harga')->default(0);
            $table->boolean('konfirmasi_pembeli')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
