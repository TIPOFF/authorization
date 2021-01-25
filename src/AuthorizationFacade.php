<?php

namespace Tipoff\Authorization;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tipoff\Authorization\Authorization
 */
class AuthorizationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'authorization';
    }
}
