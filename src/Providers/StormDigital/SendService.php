<?php

namespace Arttiger\Cpa\Providers\StormDigital;

use Arttiger\Cpa\Interfaces\Conversion\SendServiceInterface;
use Arttiger\Cpa\Interfaces\Lead\LeadSource;
use Arttiger\Cpa\Models\Conversion;
use Arttiger\Cpa\Traits\SendServiceTrait;
use GuzzleHttp\Psr7\Request;

class SendService implements SendServiceInterface
{
    use SendServiceTrait;

    public const PATH_POSTBACK = 'postback';

    public const STATUS_APPROVED = 1;

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
        $this->source = LeadSource::STORM_DIGITAL;
    }

    /**
     * Prepare and send postback request.
     *
     * @param Conversion $conversion
     * @param array $params
     * @return Request
     */
    protected function getRequest(Conversion $conversion, array $params): Request
    {
        $path = $params['path'] ?? self::PATH_POSTBACK;

        $queryParams = http_build_query([
            'clickid'   => $conversion->getConfig()['clickId'] ?? null,
            'action_id' => $conversion->getId(),
            'status'    => $params['status'] ?? self::STATUS_APPROVED,
            'goal'      => $params['goal'] ?? $this->config->getGoal($conversion->getProduct()),
            'secure'    => $params['secure'] ?? $this->config->getSecure($conversion->getProduct()),
        ]);

        $customParams = '';
        if (! empty($params['custom_params'])) {
            $customParams = '&'.http_build_query($params['custom_params']);
        }

        $url = "{$this->getDomain()}/{$path}?{$queryParams}{$customParams}";

        return new Request('get', $url);
    }
}
