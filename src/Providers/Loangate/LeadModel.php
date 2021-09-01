<?php

namespace Arttiger\Cpa\Providers\Loangate;

    class LeadModel
    {
        /**
         * Click identifier.
         * @var string
         */
        public $afclick;

        public function rules(): array
        {
            return [
                'afclick' => 'required|string',
            ];
        }
    }
