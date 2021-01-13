<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbotpHasUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbotp_has_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid("otp_id");
            $table->uuid("user_id");
            $table->timestamps();
            $table->foreign("user_id")
                ->references('id')
                ->on('users')
                ->onCascade("delete");

            $table->foreign("otp_id")
                ->references('id')
                ->on('tbotp')
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
        Schema::dropIfExists('tbotp_has_users');
    }
}
