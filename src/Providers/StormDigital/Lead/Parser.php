<?php

namespace Arttiger\Cpa\Providers\StormDigital\Lead;

use Arttiger\Cpa\Interfaces\Lead\LeadParser;
use Arttiger\Cpa\Interfaces\Lead\LeadSource;
use Arttiger\Cpa\Lead\LeadInfo;
use Arttiger\Cpa\Traits\QueryParams;

class Parser implements LeadParser
{
    use QueryParams;

    protected const UTM_SOURCES = [
        'stormdigital',
        'storm',
    ];
    protected const AFF_CLICK_ID = 'aff_click_id';
    protected const AFF_ID = 'aff_id';

    public function parse(string $url): ?LeadInfo
    {
        $query = $this->getQueryParams($url);
        $isQueryValid = in_array($query['utm_source'] ?? null, static::UTM_SOURCES, true)
            && array_key_exists(static::AFF_CLICK_ID, $query);

        if (! $isQueryValid) {
            return null;
        }

        return new LeadInfo(
            LeadSource::STORM_DIGITAL,
            [
                'clickId' => $query[static::AFF_CLICK_ID],
                'aid'     => $query[static::AFF_ID] ?? $query['utm_campaign'] ?? null,
            ]
        );
    }
}
