<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasPackageFactory;

class EmailAddress extends BaseModel
{
    use HasPackageFactory;

    protected $casts = [];

    public function user()
    {
        return $this->belongsTo(app('user'));
    }
}
