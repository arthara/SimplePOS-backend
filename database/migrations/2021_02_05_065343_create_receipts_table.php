<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stores_id')->constrained('stores')->onDelete('cascade');
            $table->timestamp('receipts_time');
            $table->string('customer_name', 100);
            $table->string('customer_phone', 100);
            $table->float('tax', 9, 2)->nullable();
            $table->float('discount', 9, 2)->nullable();
            $table->float('other_charges', 9, 2)->nullable();
            $table->string('note', 100)->nullable();
            $table->enum('payment_method', ['cash', 'debit_card', 'credit_card', 'ovo', 'gopay', 'shopeepay']);
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
        Schema::dropIfExists('receipts');
    }
}
