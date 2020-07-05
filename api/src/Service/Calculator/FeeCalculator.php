<?php

namespace App\Service\Calculator;

use DomainException;
use App\Entity\Transaction;
use App\Model\WeekCashOutCollection;

class FeeCalculator implements FeeCalculatorInterface
{
    private WeekCashOutCollection $weekCashOutCollection;
    private CashInFeeCalculatorInterface $cashInFeeCalculator;
    private CashOutFeeCalculatorInterface $cashOutFeeCalculator;

    public function __construct(
        WeekCashOutCollection $weekCashOutCollection,
        CashInFeeCalculatorInterface $cashInFeeCalculator,
        CashOutFeeCalculatorInterface $cashOutFeeCalculator
    ) {
        $this->weekCashOutCollection = $weekCashOutCollection;
        $this->cashInFeeCalculator = $cashInFeeCalculator;
        $this->cashOutFeeCalculator = $cashOutFeeCalculator;
    }

    public function calculate(Transaction ...$transactions): void
    {
        foreach ($transactions as $transaction) {
            if (Transaction::CASH_IN_OPERATION_TYPE === $transaction->getOperationType()) {
                $fee = $this->cashInFeeCalculator->calculateCashInFee($transaction);
            } elseif (Transaction::CASH_OUT_OPERATION_TYPE === $transaction->getOperationType()) {
                $fee = $this->cashOutFeeCalculator->calculateCashOutFee($transaction, $this->weekCashOutCollection);
            } else {
                throw new DomainException('Undefined transaction type.');
            }

            $transaction->setFee($fee);
            $this->weekCashOutCollection->add($transaction);
        }
    }
}
