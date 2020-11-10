<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_inventories', function (Blueprint $table) {
            $table->string('code_inventory', 15)->primary();
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('product_id');
            $table->string('product_serial_number' , 20);
            $table->date('purchase_date');
            $table->enum('condition', ['Very good','Good','Bad']);
            $table->string('information', 30);
            $table->enum('status', ['Active','Inactive']);
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_inventories');
    }
}
