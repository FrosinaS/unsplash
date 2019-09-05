<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AccessTokenScopes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_token_scopes', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('access_token_id')->nullable();
            $table->string('scope');
            $table->timestamps();

            $table->foreign('access_token_id')->references('id')->on('access_tokens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('access_token_scopes');
    }
}
