<?php

namespace Arttiger\Cpa\Providers\Appscorp;

    use Arttiger\Cpa\Traits\EnvironmentConfigTrait;

    class EnvironmentConfig
    {
        use EnvironmentConfigTrait;

        public $keyPrefix = 'APPSCORP_';

        public function getOffer(?string $product = null): int
        {
            return env($this->getProductPrefix($product).'OFFER', 0);
        }
    }
