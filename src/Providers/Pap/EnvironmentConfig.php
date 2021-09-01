<?php

namespace Arttiger\Cpa\Providers\Pap;

    use Arttiger\Cpa\Traits\EnvironmentConfigTrait;

    class EnvironmentConfig
    {
        use EnvironmentConfigTrait;

        public $keyPrefix = 'PAP_';

        public function getAccountId(?string $product = null): int
        {
            return env($this->getProductPrefix($product).'ACCOUNT_ID', 0);
        }
    }
