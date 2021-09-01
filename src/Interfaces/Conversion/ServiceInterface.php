<?php

namespace Arttiger\Cpa\Interfaces\Conversion;

use Arttiger\Cpa\Models\Conversion;

interface ServiceInterface
{
    public function register($model, string $conversionId, string $event): ?Conversion;
}
