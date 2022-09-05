<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLieusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lieus', function (Blueprint $table) {
            $table->id();
            $table->string("nom");
            $table->text("description");
            $table->unsignedBigInteger("user")->index();
            $table->unsignedBigInteger("dictionnaire")->index();
            $table->integer("likes")->default(0);
            $table->integer("dislikes")->default(0);
            $table->string("usersLiked")->default("0");
            $table->string("usersDisliked")->default("0");
            $table->timestamps();

            $table->foreign("dictionnaire")->references('id')->on("dictionnaires");
            $table->foreign("user")->references('id')->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lieus');
    }
}
