<?php

namespace Arttiger\Cpa\Providers\PapaKarlo;

use Arttiger\Cpa\Traits\EnvironmentConfigTrait;

class EnvironmentConfig
{
    use EnvironmentConfigTrait;

    public $keyPrefix = 'PAPA_KARLO_';

    public function getOffer(?string $product = null): ?int
    {
        return env($this->getProductPrefix($product).'OFFER');
    }

    public function getGoal(?string $product = null): ?int
    {
        return env($this->getProductPrefix($product).'GOAL');
    }

    public function getType(?string $product = null): ?string
    {
        return env($this->getProductPrefix($product).'TYPE');
    }
}
