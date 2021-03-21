<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('email_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->foreignIdFor(app('user'))->nullable();
            $table->boolean('primary')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }
}
