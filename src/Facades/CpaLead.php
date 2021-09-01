<?php

namespace Arttiger\Cpa\Facades;

use Arttiger\Cpa\Models\CpaCookie;
use Arttiger\Cpa\Models\Lead;
use Illuminate\Support\Facades\Facade;

/**
 * Class CpaLead.
 *
 * @method static Lead|null getLastLeadByUser($user): ?Lead
 * @method static Lead|null create($user, $urls): ?Lead
 * @method static Lead|null createFromCookie($user): ?Lead
 * @method static CpaCookie storeToCookie($url)
 *
 * @see \Arttiger\Cpa\Lead\LeadService
 */
class CpaLead extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'cpaLead';
    }
}
