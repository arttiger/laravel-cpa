<?php

namespace Arttiger\Cpa\Providers\SalesDoubler\Lead;

use Arttiger\Cpa\Interfaces\Lead\LeadParser;
use Arttiger\Cpa\Interfaces\Lead\LeadSource;
use Arttiger\Cpa\Lead\LeadInfo;
use Arttiger\Cpa\Traits\QueryParams;

class Parser implements LeadParser
{
    use QueryParams;

    protected const AFF_SUB = 'aff_sub';
    protected const AFF_ID = 'aff_id';
    protected const UTM_SOURCES = [
        'cpanet_salesdoubler',
        'cpanet_salesdubler',
        'salesdoubler',
    ];

    public function parse(string $url): ?LeadInfo
    {
        $query = $this->getQueryParams($url);
        $isQueryValid = in_array($query['utm_source'] ?? null, static::UTM_SOURCES, true)
            && array_key_exists(static::AFF_SUB, $query);
        if (! $isQueryValid) {
            return null;
        }

        return new LeadInfo(
            LeadSource::SALES_DOUBLER,
            [
                'clickId' => $query[static::AFF_SUB],
                'aid'     => $query[static::AFF_ID] ?? $query['utm_campaign'] ?? null,
            ]
        );
    }
}
