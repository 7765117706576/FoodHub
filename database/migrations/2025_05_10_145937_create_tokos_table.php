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
        Schema::create('tokos', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko');
            $table->text('deskripsi')->nullable();
            $table->string('alamat')->nullable();
            $table->timestamps();
        });
        Schema::table('tokos', function(Blueprint $table){
            $table->foreignId('user_id')->after('id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::dropIfExists('tokos');
        Schema::table('tokos', function(Blueprint $table){
            $table->dropColumn('user_id');
            
        });
        
        
    }
};
