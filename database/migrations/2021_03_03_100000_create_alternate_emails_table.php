<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlternateEmailsTable extends Migration
{
    public function up()
    {
        Schema::create('alternate_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alternate_emails');
    }
}
