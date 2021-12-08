<?php

namespace Arttiger\Cpa\Providers\Appscorp;

use Arttiger\Cpa\Interfaces\Conversion\SendServiceInterface;
use Arttiger\Cpa\Interfaces\Lead\LeadSource;
use Arttiger\Cpa\Models\Conversion;
use Arttiger\Cpa\Traits\SendServiceTrait;
use GuzzleHttp\Psr7\Request;

class SendService implements SendServiceInterface
{
    use SendServiceTrait;

    public const PATH_POSTBACK = 'pb';

    /**
     * @var EnvironmentConfig
     */
    protected EnvironmentConfig $config;

    /**
     * SendService constructor.
     *
     * @param EnvironmentConfig $config
     */
    public function __construct(EnvironmentConfig $config)
    {
        $this->config = $config;
        $this->source = LeadSource::APPSCORP;
    }

    protected function getRequest(Conversion $conversion, array $params): Request
    {
        $path = $params['path'] ?? self::PATH_POSTBACK;

        $queryParams = http_build_query([
            'data1'         => $conversion->getConfig()['data1'] ?? null,
            'transactionId' => $conversion->getId(),
            'actionName'    => $params['action'] ?? null,
            'comission'     => $params['comission'] ?? null,
            'status'        => $params['status'] ?? null,
            'campaignName'  => $params['campaign'] ?? null,
            'gclid'         => $conversion->getConfig()['gclid'] ?? null,
        ]);

        $customParams = '';
        if (! empty($params['custom_params'])) {
            $customParams = '&'.http_build_query($params['custom_params']);
        }

        $url = "{$this->getDomain()}/{$path}?{$queryParams}{$customParams}";

        return new Request('get', $url);
    }
}
