<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfTokenGet extends Middleware
{
    protected function isReading($request)
    {
        // 'GET' is not included!
        return in_array($request->method(), ['HEAD', 'OPTIONS']);
    }
}
