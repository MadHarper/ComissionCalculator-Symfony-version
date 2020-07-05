<?php

declare(strict_types=1);

namespace App\Service\Calculator;

use App\Entity\Money;
use App\Entity\Transaction;

interface FeeStrategyInterface
{
    public function calculateFee(Transaction $transaction): Money;

    public function support(Transaction $transaction): bool;
}
