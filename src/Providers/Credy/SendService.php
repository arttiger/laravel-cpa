<?php

namespace Arttiger\Cpa\Providers\Credy;

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
         *
         * @param EnvironmentConfig $config
         */
        public function __construct(EnvironmentConfig $config)
        {
            $this->config = $config;
            $this->source = LeadSource::CREDY;
        }

        protected function getRequest(Conversion $conversion, array $params): Request
        {
            $transactionId = $conversion->getConfig()['transaction_id'] ?? null;
            $offer = $offerId = $params['offer_id'] ?? $this->config->getOffer($conversion->getProduct());
            $goalId = $params['goal_id'] ?? $this->config->getGoal($conversion->getProduct());
            $conversionId = $conversion->getId();

            $type = $params['type'] ?? $this->config->getType($conversion->getProduct());
            $path = ($type === 'offer') ? 'aff_lsr' : 'aff_goal';

            if ($type === 'offer') {
                $queryParams = http_build_query([
                    'offer_id'       => $offer,
                    'transaction_id' => $transactionId,
                    'adv_sub'        => $conversionId,
                ]);
            } else {
                $queryParams = http_build_query([
                    'a'              => 'lsr',
                    'goal_id'        => $goalId,
                    'transaction_id' => $transactionId,
                    'adv_sub'        => $conversionId,
                ]);
            }

            $customParams = '';
            if (! empty($params['custom_params'])) {
                $customParams = '&'.http_build_query($params['custom_params']);
            }

            $url = "{$this->getDomain()}/{$path}?{$queryParams}{$customParams}";

            return new Request('get', $url);
        }
    }
