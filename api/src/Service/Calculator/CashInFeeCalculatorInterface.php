<?php

declare(strict_types=1);

namespace App\Service\Calculator;

use App\Entity\Money;
use App\Entity\Transaction;

interface CashInFeeCalculatorInterface
{
    public function calculateCashInFee(Transaction $transaction): Money;
}
