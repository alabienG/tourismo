<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictionnairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionnaires', function (Blueprint $table) {
            $table->id();
            $table->string("nom");
            $table->boolean("pays")->default(false);
            $table->boolean("region")->default(false);
            $table->boolean("ville")->default(false);
            $table->unsignedBigInteger("parent")->nullable();
            $table->timestamps();

//            $table->foreign("parent")->references('id')->on("dictionnaires");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dictionnaires');
    }
}
