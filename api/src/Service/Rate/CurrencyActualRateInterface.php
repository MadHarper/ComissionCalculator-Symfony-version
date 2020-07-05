<?php

namespace App\Service\Rate;

use Symfony\Component\HttpFoundation\ParameterBag;

interface CurrencyActualRateInterface
{
    public function getActualRates(): ParameterBag;
}