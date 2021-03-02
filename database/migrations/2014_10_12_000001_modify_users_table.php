<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $column = $table->string('name_last')->after('creator_id');
            // Workaround for Sqlite / ALTER
            // - https://stackoverflow.com/questions/20822159/laravel-migration-with-sqlite-cannot-add-a-not-null-column-with-default-value-n
            if (config("database.default") === "testing") {
                $column->default('');
            }
            $table->text('bio')->nullable()->after('password'); // Will be written in Markdown. The user profile image will come from Gravatar account for the email address.
            $table->text('title')->nullable()->after('bio');
            $table->softDeletes()->after('title');

            // needed for Laravel Socialite
            $table->string('password')->nullable()->change();
            $table->string('provider_name')->nullable()->after('password');
            $table->string('provider_id')->unique()->nullable()->after('provider');

        });
    }
}
