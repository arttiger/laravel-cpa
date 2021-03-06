<?php

namespace Arttiger\Cpa\Lead\Parser;

use Arttiger\Cpa\Interfaces\Lead\LeadParser;
use Arttiger\Cpa\Lead\LeadInfo;

class Chain implements LeadParser
{
    public $parsers;

    /**
     * Chain constructor.
     */
    public function __construct()
    {
        $this->parsers = (new ParsersFactory())->create();
    }

    public function parse(string $url): ?LeadInfo
    {
        foreach ($this->parsers as $parser) {
            $leadInfo = $parser->parse($url);
            if ($leadInfo instanceof LeadInfo) {
                return $leadInfo;
            }
        }

        return null;
    }
}
