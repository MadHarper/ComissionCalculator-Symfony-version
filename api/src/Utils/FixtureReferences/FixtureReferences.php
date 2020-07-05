<?php

namespace App\Utils\FixtureReferences;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;

final class FixtureReferences
{
    private $references = [];
    private $fixtures;

    private static function getInstance(): FixtureReferences
    {
        static $instance;

        if (null === $instance) {
            $instance = new self();
        }

        return $instance;
    }

    private function __construct()
    {
        static $hasInstance = false;

        if ($hasInstance) {
            \trigger_error('Class is already instantiated', \E_USER_ERROR);
        }

        $hasInstance = true;
    }

    private function __clone()
    {
        \trigger_error('Class could not be cloned', \E_USER_ERROR);
    }

    private function __wakeup()
    {
        \trigger_error('Class could not be deserialized', \E_USER_ERROR);
    }

    public static function get($fixtures, string $class)
    {
        if (!$fixtures instanceof ORMFixtureInterface) {
            \trigger_error(sprintf('A fixture must be with the interface %s', ORMFixtureInterface::class));
        }

        $i = self::getInstance();
        $i->fixtures = $fixtures;
        if (!array_key_exists($class, $i->references)) {
            $i->references[$class] = new $class($i->fixtures);
        }

        return $i->references[$class];
    }
}