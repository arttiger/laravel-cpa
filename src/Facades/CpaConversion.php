<?php

namespace Arttiger\Cpa\Facades;

use Arttiger\Cpa\Models\Conversion;
use Illuminate\Support\Facades\Facade;

/**
 * Class CpaConversion.
 * @method static Conversion register($user, string $conversionId, string $event, array $custom_params = [])
 *
 * @see \Arttiger\Cpa\Conversion\ConversionService
 */
class CpaConversion extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'cpaConversion';
    }
}
