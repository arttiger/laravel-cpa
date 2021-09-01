<?php

namespace Arttiger\Cpa\Providers\Appscorp\Lead;

    use Arttiger\Cpa\Interfaces\Lead\LeadParser;
    use Arttiger\Cpa\Interfaces\Lead\LeadSource;
    use Arttiger\Cpa\Lead\LeadInfo;
    use Arttiger\Cpa\Traits\QueryParams;

    class Parser implements LeadParser
    {
        use QueryParams;

        protected const UTM_SOURCE = 'semsale';
        protected const CLICK_ID = 'data1';

        public function parse(string $url): ?LeadInfo
        {
            $query = $this->getQueryParams($url);
            $isQueryValid = ($query['utm_source'] ?? null) === static::UTM_SOURCE
                && array_key_exists(static::CLICK_ID, $query);

            if (! $isQueryValid) {
                return null;
            }

            return new LeadInfo(
                LeadSource::APPSCORP,
                [
                    'data1'  => $query[static::CLICK_ID],
                    'gclid' => $query['gclid'] ?? null,
                    'webmaster_id' => $query['webmaster_id'] ?? null,
                ]
            );
        }
    }
