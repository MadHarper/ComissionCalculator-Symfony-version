<?php

namespace App\Service\Calculator;

use App\Entity\Money;
use App\Entity\Transaction;
use App\Model\WeekCashOutCollection;

interface CashOutFeeCalculatorInterface
{
    public function calculateCashOutFee(Transaction $transaction, WeekCashOutCollection $weekCashOutCollection): Money;
}
