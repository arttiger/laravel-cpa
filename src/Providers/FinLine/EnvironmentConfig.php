<?php

namespace Arttiger\Cpa\Providers\FinLine;

use Arttiger\Cpa\Traits\EnvironmentConfigTrait;

class EnvironmentConfig
{
    use EnvironmentConfigTrait;

    public $keyPrefix = 'FIN_LINE_';
}
