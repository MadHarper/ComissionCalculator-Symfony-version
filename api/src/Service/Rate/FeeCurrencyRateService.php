<?php

namespace App\Service\Rate;

use App\Entity\Money;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Любая имплементация получения курса валют, это может быть обращение к стороннему сервису, или извлечение из БД
 *
 */
class FeeCurrencyRateService implements CurrencyActualRateInterface
{
    private array $rates = [
        Money::EUR => 1,
        Money::USD => 1.1497,
        Money::JPY => 129.53,
    ];

    public function getActualRates(): ParameterBag
    {
        return new ParameterBag($this->rates);
    }
}