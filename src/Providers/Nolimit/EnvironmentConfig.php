<?php

namespace Arttiger\Cpa\Providers\Nolimit;

    use Arttiger\Cpa\Traits\EnvironmentConfigTrait;

    class EnvironmentConfig
    {
        use EnvironmentConfigTrait;

        public $keyPrefix = 'NOLIMIT_';

        public function getPath(?string $product = null): string
        {
            return env($this->appendProductPrefix('PATH', $product));
        }
    }
