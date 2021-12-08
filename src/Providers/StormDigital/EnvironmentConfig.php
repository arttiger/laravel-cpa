<?php

namespace Arttiger\Cpa\Providers\StormDigital;

use Arttiger\Cpa\Traits\EnvironmentConfigTrait;

class EnvironmentConfig
{
    use EnvironmentConfigTrait;

    public string $keyPrefix = 'STORM_DIGITAL_';

    public function getSecure(?string $product = null): string
    {
        return env($this->getProductPrefix($product).'SECURE', '');
    }

    public function getGoal(?string $product = null): int
    {
        return env($this->getProductPrefix($product).'GOAL', 1);
    }
}
