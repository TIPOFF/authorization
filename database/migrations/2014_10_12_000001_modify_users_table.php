<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTable extends Migration
{
    public function up()
    {
        // Isolate rename in its own changeset, Sqlite has (silent) failures otherwise
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'first_name');
        });

        Schema::table('users', function (Blueprint $table) {
            $column = $table->string('last_name')->after('first_name');
            // Workaround for Sqlite / ALTER
            // - https://stackoverflow.com/questions/20822159/laravel-migration-with-sqlite-cannot-add-a-not-null-column-with-default-value-n
            if (config("database.default") === "testing") {
                $column->default('');
            }
            $table->string('username')->after('last_name');
            // Temporary workaround for Sqlite / ALTER
            // @todo need better testing solution
            if (config("database.default") !== "testing") {
                $column->unique();
            }
            if (config("database.default") === "testing") {
                $column->nullable();
            }
            $table->text('bio')->nullable()->after('password'); // Will be written in Markdown. The user profile image will come from Gravatar account for the email address.
            $table->text('title')->nullable()->after('bio');
            $table->softDeletes()->after('title');

            // needed for Laravel Socialite
            $table->string('provider_name')->nullable()->after('password');
            $table->string('provider_id')->unique()->nullable()->after('provider_name');
        });
    }
}
