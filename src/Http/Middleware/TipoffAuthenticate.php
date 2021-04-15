<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate;

class TipoffAuthenticate extends Authenticate
{
    private array $guards = [];

    public function handle($request, Closure $next, ...$guards)
    {
        $this->guards = $guards;

        return parent::handle($request, $next, ...$guards);
    }

    protected function redirectTo($request)
    {
        if (in_array('email', $this->guards)) {
            return route('authorization.email-login');
        }

        // TODO - change to regular user login route, view & controller when available
        return route('authorization.email-login');
    }
}
