<?php

namespace Arttiger\Cpa\Facades;

use Illuminate\Support\Facades\Facade;

class Cpa extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cpa';
    }
}
