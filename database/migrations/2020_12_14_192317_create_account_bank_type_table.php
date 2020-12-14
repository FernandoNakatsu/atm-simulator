<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountBankTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_bank_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->timestamps();
        });

        DB::table('account_bank_type')->insert([
            "id" => 1,
            "description" => "Corrente",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);

        DB::table('account_bank_type')->insert([
            "id" => 2,
            "description" => "Poupança",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_bank_type');
    }
}
