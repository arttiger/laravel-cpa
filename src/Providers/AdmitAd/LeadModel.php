<?php

namespace Arttiger\Cpa\Providers\AdmitAd;

class LeadModel
{
    /**
     * Click identifier.
     *
     * @var string
     */
    public string $transactionId;

    public function rules(): array
    {
        return [
            'uid' => 'required|string',
        ];
    }
}
