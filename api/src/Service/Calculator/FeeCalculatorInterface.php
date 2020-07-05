<?php

namespace App\Service\Calculator;

use App\Entity\Transaction;

interface FeeCalculatorInterface
{
    public function calculate(Transaction ...$transactions): void;
}
