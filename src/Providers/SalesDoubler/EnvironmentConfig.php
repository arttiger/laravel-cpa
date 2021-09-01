<?php

namespace Arttiger\Cpa\Providers\SalesDoubler;

use Arttiger\Cpa\Traits\EnvironmentConfigTrait;

class EnvironmentConfig
{
    use EnvironmentConfigTrait;

    public $keyPrefix = 'SALES_DOUBLER_';

    public function getId(?string $product = null): int
    {
        return env($this->getProductPrefix($product).'ID', 0);
    }

    public function getToken(?string $product = null): string
    {
        return env($this->getProductPrefix($product).'TOKEN', '');
    }
}
