<?php

namespace Arttiger\Cpa\Providers\Appscorp;

class LeadModel
{
    /**
     * Click identifier.
     *
     * @var string
     */
    public string $data1;

    /**
     * Web master identifier.
     *
     * @var string
     */
    public string $gclid;

    public function rules(): array
    {
        return [
            'data1'  => 'required|string',
            'gclid' => 'required|string',
        ];
    }
}
