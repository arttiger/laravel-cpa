<?php

namespace Arttiger\Cpa\Providers\StormDigital;

class LeadModel
{
    /**
     * Click identifier.
     *
     * @var string
     */
    public string $clickId;

    /**
     * Web master identifier.
     *
     * @var string
     */
    public string $aid;

    public function rules(): array
    {
        return [
            'clickId' => 'required|string',
            'aid'     => 'string',
        ];
    }
}
