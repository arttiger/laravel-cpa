<?php

namespace Arttiger\Cpa\Providers\Loangate;

use Arttiger\Cpa\Traits\EnvironmentConfigTrait;

class EnvironmentConfig
{
    use EnvironmentConfigTrait;

    public $keyPrefix = 'LOANGATE_';

    public function getSecure(?string $product = null): string
    {
        return env($this->getProductPrefix($product).'SECURE', 0);
    }
}
