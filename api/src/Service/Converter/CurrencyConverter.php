<?php

namespace App\Service\Converter;

use App\Service\Rate\CurrencyActualRateInterface;
use DomainException;
use App\Entity\Money;

class CurrencyConverter implements CurrencyConverterInterface
{
    private $rates = [];

    private CurrencyActualRateInterface $actualRatesService;

    public function __construct(CurrencyActualRateInterface $actualRatesService)
    {
        $this->actualRatesService = $actualRatesService;
    }

    public function convert(Money $money, string $toCurrency): Money
    {
        $this->prepare();
        $fromCurrency = $money->getCurrency();
        $this->check($fromCurrency);
        $this->check($toCurrency);
        $convertedAmount = $this->rates[$toCurrency] / $this->rates[$fromCurrency] * $money->getAmount();

        return new Money($convertedAmount, $toCurrency);
    }

    private function prepare(): void
    {
        if ($this->rates) {
            return;
        }

        foreach ($this->actualRatesService->getActualRates() as $currency => $value) {
            $this->setRate($currency, $value);
        }
    }

    private function check(string $currency)
    {
        if (!array_key_exists($currency, $this->rates)) {
            throw new DomainException(sprintf('No currency rate for %s', $currency));
        }
    }

    /**
     *  Change current rate method.
     */
    public function setRate(string $currency, float $rate)
    {
        $this->rates[$currency] = $rate;
    }

    public function getRate(string $currency): float
    {
        $this->check($currency);

        return $this->rates[$currency];
    }
}
