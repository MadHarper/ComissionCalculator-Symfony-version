<?php

declare(strict_types=1);

namespace App\Service\Calculator;

use App\Service\Converter\CurrencyConverterInterface;
use App\Entity\Money;
use App\Entity\Transaction;

class CashInFeeCalculator implements CashInFeeCalculatorInterface
{
    const LIMIT_CURRENCY = Money::EUR;
    const CASH_IN_FEE_MAX_AMOUNT = 5.;
    const CASH_IN_FEE = .03;

    private Money $maxFeeMoney;
    private CurrencyConverterInterface $converter;

    public function __construct(CurrencyConverterInterface $converter)
    {
        $this->converter = $converter;
        $this->maxFeeMoney = new Money(self::CASH_IN_FEE_MAX_AMOUNT, self::LIMIT_CURRENCY);
    }

    public function calculateCashInFee(Transaction $transaction): Money
    {
        $money = $transaction->getMoney();
        $percents = $money
            ->getPercent(self::CASH_IN_FEE)
            ->round();

        $limit = $this->converter
            ->convert($this->maxFeeMoney, $money->getCurrency())
            ->round();

        return $percents->greaterThan($limit) ? $limit : $percents;
    }
}
