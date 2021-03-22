<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayHistoryTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('pay_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('order_id')->default(0);
            $table->double('amount');
            $table->string('billing_address',100);
            $table->string('payment_method',100);
            $table->enum('payment_status',['accepted','pending','failed'])->default('pending');
            $table->enum('payment_type',['order','wallet']);
            $table->timestamp('payment_date');
            $table->timestamps();
        });
        
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('pay_histories');
    }
}
