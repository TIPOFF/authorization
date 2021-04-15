<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Tipoff\Authorization\Http\Requests\Auth\EmailLoginRequest;
use Tipoff\Authorization\Models\EmailAddress;
use Tipoff\Support\Http\Controllers\BaseController;

class AuthController extends BaseController
{
    public function emailLogin(EmailLoginRequest $request)
    {
        /** @var EmailAddress $emailAddress */
        $emailAddress = EmailAddress::query()->firstOrCreate(['email' => trim(strtolower($request->email))]);
        Auth::guard('email')->login($emailAddress);

        $request->session()->regenerate();

        return redirect()->intended();
    }
}

