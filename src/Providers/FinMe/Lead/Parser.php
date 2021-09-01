<?php

namespace Arttiger\Cpa\Providers\FinMe\Lead;

use Arttiger\Cpa\Interfaces\Lead\LeadParser;
use Arttiger\Cpa\Interfaces\Lead\LeadSource;
use Arttiger\Cpa\Lead\LeadInfo;
use Arttiger\Cpa\Traits\QueryParams;

class Parser implements LeadParser
{
    use QueryParams;

    protected const UTM_SOURCES = ['finme', 'Finme'];
    protected const CLICK_ID = 'clickid';

    public function parse(string $url): ?LeadInfo
    {
        $query = $this->getQueryParams($url);
        $isQueryValid = in_array(($query['utm_source'] ?? null), static::UTM_SOURCES, true)
            && array_key_exists(static::CLICK_ID, $query);

        if (! $isQueryValid) {
            return null;
        }

        return new LeadInfo(
            LeadSource::FIN_ME,
            [
                'clickId'    => $query[static::CLICK_ID],
                'utm_medium' => $query['utm_medium'] ?? null,
            ]
        );
    }
}
