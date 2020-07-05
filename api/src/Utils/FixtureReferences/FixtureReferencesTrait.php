<?php

namespace App\Utils\FixtureReferences;

use App\DataFixtures\References\AppUserReferences;
use App\DataFixtures\References\TransactionReferences;

trait FixtureReferencesTrait
{
    public function appUserReferences(): AppUserReferences
    {
        return FixtureReferences::get($this, AppUserReferences::class);
    }

    public function transactionReferences(): TransactionReferences
    {
        return FixtureReferences::get($this, TransactionReferences::class);
    }
}
