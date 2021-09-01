<?php

namespace Arttiger\Cpa\Providers\GoodAff;

    use Arttiger\Cpa\Traits\EnvironmentConfigTrait;

    class EnvironmentConfig
    {
        use EnvironmentConfigTrait;

        public $keyPrefix = 'GOOD_AFF_';

        public function getCampaignId(?string $product = null): int
        {
            return env($this->getProductPrefix($product).'CAMPAIGN_ID', 0);
        }
    }
