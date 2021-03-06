<?php

namespace Arttiger\Cpa\Providers\Loangate;

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
            $this->source = LeadSource::LOANGATE;
        }

        protected function getRequest(Conversion $conversion, array $params): Request
        {
            $clickId = $conversion->getConfig()['afclick'] ?? null;
            $actionId = $conversion->getId();
            $secure = $params['secure'] ?? $this->config->getSecure($conversion->getProduct());
            $goal = $params['goal'] ?? null;

            $queryParams = http_build_query([
                'clickid'   => $clickId,
                'action_id' => $actionId,
                'goal'      => $goal,
                'secure'    => $secure,
            ]);

            $customParams = '';
            if (! empty($params['custom_params'])) {
                $customParams = '&'.http_build_query($params['custom_params']);
            }

            $url = "{$this->getDomain()}/postback?{$queryParams}{$customParams}";

            return new Request('get', $url);
        }
    }
