<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class EmailLoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }
}
