<?php

namespace Arttiger\Cpa\Providers\FinMe;

    use Arttiger\Cpa\Traits\EnvironmentConfigTrait;

    class EnvironmentConfig
    {
        use EnvironmentConfigTrait;

        public $keyPrefix = 'FIN_ME_';
    }
