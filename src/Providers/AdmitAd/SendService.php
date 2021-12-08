<?php

namespace Arttiger\Cpa\Providers\AdmitAd;

use Arttiger\Cpa\Interfaces\Conversion\SendServiceInterface;
use Arttiger\Cpa\Interfaces\Lead\LeadSource;
use Arttiger\Cpa\Models\Conversion;
use Arttiger\Cpa\Traits\SendServiceTrait;
use GuzzleHttp\Psr7\Request;

class SendService implements SendServiceInterface
{
    use SendServiceTrait;

    public const PATH_POSTBACK = 'r';

    public const PAYMENT_TYPE_SALE = 'sale';
    public const PAYMENT_TYPE_LEAD = 'lead';

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
        $this->source = LeadSource::ADMITAD;
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
            'order_id'      => $conversion->getId(),
            'uid'           => $conversion->getConfig()['uid'] ?? null,
            'postback'      => $params['postback'] ?? 1,
            'campaign_code' => $params['campaign_code'] ?? $this->config->getCampaignCode($conversion->getProduct()),
            'postback_key'  => $params['postback_key'] ?? $this->config->getPostbackKey($conversion->getProduct()),
            'action_code'   => $params['action_code'] ?? $this->config->getActionCode($conversion->getProduct()),
            'tariff_code'   => $params['tariff_code'] ?? $this->config->getTariffCode($conversion->getProduct()),
            'payment_type'  => $params['payment_type'] ?? self::PAYMENT_TYPE_SALE,
        ]);

        $customParams = '';
        if (! empty($params['custom_params'])) {
            $customParams = '&'.http_build_query($params['custom_params']);
        }

        $url = "{$this->getDomain()}/{$path}?{$queryParams}{$customParams}";

        return new Request('get', $url);
    }
}
