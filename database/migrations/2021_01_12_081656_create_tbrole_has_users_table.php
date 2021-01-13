<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbroleHasUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbrole_has_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid("user_id");
            $table->uuid("role_id");
            $table->timestamps();
            $table->foreign("user_id")
                ->references('id')
                ->on('users')
                ->onCascade("delete");

            $table->foreign("role_id")
                ->references('id')
                ->on('tbroles')
                ->onCascade("delete");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbrole_has_users');
    }
}
