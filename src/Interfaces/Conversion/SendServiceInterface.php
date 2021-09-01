<?php

namespace Arttiger\Cpa\Interfaces\Conversion;

use Arttiger\Cpa\Conversion\Postback;
use Arttiger\Cpa\Models\Conversion;

interface SendServiceInterface
{
    public function send(Conversion $conversion, array $params): Postback;

    public function getDomain(): string;

    public function getSource(): string;
}
