<?php

namespace Arttiger\Cpa\Providers\GuruLeads;

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
            $this->source = LeadSource::GURU_LEADS;
        }

        protected function getRequest(Conversion $conversion, array $params): Request
        {
            $clickId = $conversion->getConfig()['click_id'] ?? null;
            $conversionId = $conversion->getId();

            $path = $params['path'] ?? $this->config->getPath($conversion->getProduct());
            $goal = $params['goal'] ?? null;
            $status = $params['status'] ?? null;

            $queryParams = http_build_query([
                'clickid'   => $clickId,
                'action_id' => $conversionId,
                'goal'      => $goal,
                'status'    => $status,
            ]);

            $customParams = '';
            if (! empty($params['custom_params'])) {
                $customParams = '&'.http_build_query($params['custom_params']);
            }

            $url = "{$this->getDomain()}/{$path}?{$queryParams}{$customParams}";

            return new Request('get', $url);
        }
    }
