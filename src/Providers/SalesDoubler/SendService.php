<?php

namespace Arttiger\Cpa\Providers\SalesDoubler;

use Arttiger\Cpa\Interfaces\Conversion\SendServiceInterface;
use Arttiger\Cpa\Interfaces\Lead\LeadSource;
use Arttiger\Cpa\Models\Conversion;
use Arttiger\Cpa\Traits\SendServiceTrait;
use GuzzleHttp\Psr7\Request;

class SendService implements SendServiceInterface
{
    use SendServiceTrait;

    /**
     * @var EnvironmentConfig
     */
    protected $config;

    /**
     * SendService constructor.
     * @param EnvironmentConfig $config
     */
    public function __construct(EnvironmentConfig $config)
    {
        $this->config = $config;
        $this->source = LeadSource::SALES_DOUBLER;
    }

    protected function getRequest(Conversion $conversion, array $params): Request
    {
        $clickId = $conversion->getConfig()['clickId'] ?? null;
        $transId = $conversion->getId();
        $affId = $conversion->getConfig()['aid'] ?? null;
        $token = $this->config->getToken($conversion->getProduct());
        $id = $this->config->getId($conversion->getProduct());

        $customParams = '';
        if (! empty($params['custom_params'])) {
            $customParams = '&'.http_build_query($params['custom_params']);
        }

        $url = "{$this->getDomain()}/in/postback/{$id}/{$clickId}?trans_id={$transId}&aff_id={$affId}&token={$token}{$customParams}";

        return new Request('get', $url);
    }
}
