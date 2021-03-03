<?php

declare(strict_types=1);

namespace Tipoff\Authorization\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class AlternateEmail extends BaseModel
{
    use HasCreator;
    use HasUpdater;
    use HasPackageFactory;

    protected $casts = [];
    protected $fillable = ['email'];

    public function user()
    {
        return $this->belongsTo(app('user'));
    }
}
