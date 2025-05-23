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
        Schema::create('transaksi_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('products_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('stocks_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('transaksi_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer("jumlah");
            $table->decimal("total_harga");
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
        Schema::dropIfExists('transaksi_details');
    }
};
