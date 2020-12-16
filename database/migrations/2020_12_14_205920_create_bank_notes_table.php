<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->integer('value');
            $table->timestamps();
        });

        DB::table('bank_notes')->insert([
            "id" => 1,
            "description" => "Nota de 20",
            "value" => 20,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);

        DB::table('bank_notes')->insert([
            "id" => 2,
            "description" => "Nota de 50",
            "value" => 50,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);

        DB::table('bank_notes')->insert([
            "id" => 3,
            "description" => "Nota de 100",
            "value" => 100,
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
        Schema::dropIfExists('bank_notes');
    }
}
