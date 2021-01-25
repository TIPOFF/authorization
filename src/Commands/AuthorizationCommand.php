<?php

namespace Tipoff\Authorization\Commands;

use Illuminate\Console\Command;

class AuthorizationCommand extends Command
{
    public $signature = 'authorization';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
