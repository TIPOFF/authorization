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
            $table->renameColumn('name', 'first_name');
            $table->text('bio')->nullable()->after('password'); // Will be written in Markdown. The user profile image will come from Gravatar account for the email address.
            $table->text('title')->nullable()->after('bio');
            $table->softDeletes()->after('title');
        });

        Schema::table('users', function (Blueprint $table) {
            $column = $table->string('last_name')->after('first_name');
            // Workaround for Sqlite / ALTER
            // - https://stackoverflow.com/questions/20822159/laravel-migration-with-sqlite-cannot-add-a-not-null-column-with-default-value-n
            if (config("database.default") === "testing") {
                $column->default('');
            }
        });
    }
}
