<?php

namespace App\Traits;

use App\Scopes\ProjectScope;

trait HasProjectScope
{
    protected static function bootHasProjectScope()
    {
        static::addGlobalScope(new ProjectScope());
    }
}
