<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGarageUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garage_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ticket_number');

            $table->unsignedInteger('garage_id');
            $table->unsignedInteger('rate_id');

            $table->timestamp('entered_at', 0)->nullable();
            $table->timestamp('exited_at', 0)->nullable();

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
        Schema::dropIfExists('garage_users');
    }
}
