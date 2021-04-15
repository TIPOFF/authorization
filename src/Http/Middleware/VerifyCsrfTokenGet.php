<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfTokenGet extends Middleware
{
    protected function getTokenFromRequest($request)
    {
        if ($token = $request->route('_token')) {
            return (string) $token;
        }

        return parent::getTokenFromRequest($request);
    }

    protected function isReading($request)
    {
        // 'GET' is not included!
        return in_array($request->method(), ['HEAD', 'OPTIONS']);
    }
}
