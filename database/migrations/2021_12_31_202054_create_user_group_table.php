<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGroupTable extends Migration
{
    public function up()
    {
        Schema::create('user_group', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id')->index();
            $table->uuid('group_id')->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_group');
    }
}
