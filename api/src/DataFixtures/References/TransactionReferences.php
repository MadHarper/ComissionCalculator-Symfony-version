<?php

namespace App\DataFixtures\References;

use App\Entity\Transaction;
use App\Utils\FixtureReferences\Reference;

/**
 * @package App\DataFixtures\References
 *
 * @method void add($key, Transaction $object)
 * @method Transaction get($key)
 * @method Transaction getRandom()
 * @method Transaction|null getRandomOrNull()
 */
class TransactionReferences extends Reference
{
    public function getName(): string
    {
        return 'transaction_';
    }
}