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
            $table->string('email')->unique();
            $table->foreignIdFor(app('user'));
            $table->timestamps();
        });
    }
}
