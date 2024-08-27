<?php

namespace Spatie\remote\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\remote\remote
 */
class remote extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Spatie\remote\remote::class;
    }
}
