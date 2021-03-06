<?php

namespace Arttiger\Cpa\Providers\LeadGid\Lead;

use Arttiger\Cpa\Interfaces\Lead\LeadParser;
use Arttiger\Cpa\Interfaces\Lead\LeadSource;
use Arttiger\Cpa\Lead\LeadInfo;
use Arttiger\Cpa\Traits\QueryParams;

class Parser implements LeadParser
{
    use QueryParams;

    protected const CLICK_ID = 'click_id';
    protected const WM_ID = 'wm_id';

    protected const UTM_SOURCES = [
        'leadgid',
        'leadGid',
        'lead_gid',
    ];

    public function parse(string $url): ?LeadInfo
    {
        $query = $this->getQueryParams($url);
        $isQueryValid = in_array($query['utm_source'] ?? null, static::UTM_SOURCES, true)
            && array_key_exists(static::CLICK_ID, $query);
        if (! $isQueryValid) {
            return null;
        }

        return new LeadInfo(
            LeadSource::LEAD_GID,
            [
                'click_id' => $query[static::CLICK_ID],
                'wm_id'    => $query[static::WM_ID] ?? null,
            ]
        );
    }
}
