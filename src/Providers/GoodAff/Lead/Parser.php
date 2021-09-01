<?php

namespace Arttiger\Cpa\Providers\GoodAff\Lead;

use Arttiger\Cpa\Interfaces\Lead\LeadParser;
use Arttiger\Cpa\Interfaces\Lead\LeadSource;
use Arttiger\Cpa\Lead\LeadInfo;
use Arttiger\Cpa\Traits\QueryParams;

class Parser implements LeadParser
{
    use QueryParams;

    protected const UTM_SOURCE = 'goodaff';
    protected const CLICK_ID = 'click_id';

    public function parse(string $url): ?LeadInfo
    {
        $query = $this->getQueryParams($url);
        $isQueryValid = ($query['utm_source'] ?? null) === static::UTM_SOURCE
            && array_key_exists(static::CLICK_ID, $query);

        if (! $isQueryValid) {
            return null;
        }

        return new LeadInfo(
            LeadSource::GOOD_AFF,
            [
                'click_id'     => $query[static::CLICK_ID],
                'utm_medium'   => $query['utm_medium'] ?? null,
                'utm_campaign' => $query['utm_campaign'] ?? null,
            ]
        );
    }
}
