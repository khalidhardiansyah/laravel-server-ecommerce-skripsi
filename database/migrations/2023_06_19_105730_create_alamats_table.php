<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alamats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provinsi_id');
            $table->unsignedBigInteger('kabupaten_id');
            $table->unsignedBigInteger('kecamatan_id');
            $table->unsignedBigInteger('kelurahan_id');
            $table->longText("alamat_detail");
            $table->string("kode_pos");
            $table->unsignedBigInteger('user_id');
            $table->foreign('provinsi_id')->references('id')->on('indonesia_provinces')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('kabupaten_id')->references('id')->on('indonesia_cities')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('kecamatan_id')->references('id')->on('indonesia_districts')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('kelurahan_id')->references('id')->on('indonesia_villages')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alamats');
    }
};
