<?php

namespace App\DataFixtures\References;

use App\Entity\AppUser;
use App\Utils\FixtureReferences\Reference;

/**
 * @package App\DataFixtures\References
 *
 * @method void add($key, AppUser $object)
 * @method AppUser get($key)
 * @method AppUser getRandom()
 * @method AppUser|null getRandomOrNull()
 */
class AppUserReferences extends Reference
{
    public function getName(): string
    {
        return 'app_user_';
    }
}