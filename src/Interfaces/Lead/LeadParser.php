<?php

namespace Arttiger\Cpa\Interfaces\Lead;

use Arttiger\Cpa\Lead\LeadInfo;

interface LeadParser
{
    public function parse(string $url): ?LeadInfo;
}
