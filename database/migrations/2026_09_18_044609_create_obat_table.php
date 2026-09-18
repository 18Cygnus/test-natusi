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
        Schema::create('obat', function (Blueprint $table) {
            $table->bigIncrements('id_obat');
            $table->string('kode_obat', 45)->unique();
            $table->string('nama_obat', 255);
            $table->string('satuan_obat', 45);
            $table->double('harga_obat');
            $table->integer('stok_obat')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};
