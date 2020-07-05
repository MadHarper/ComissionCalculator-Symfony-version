<?php

namespace App\Utils;

abstract class BasicEnum
{
    private static $constCacheArray = null;

    /**
     * Preventing instance
     */
    private function __construct()
    {
    }

    public static function getConstList()
    {
        if (null === self::$constCacheArray) {
            self::$constCacheArray = [];
        }
        $calledClass = static::class;
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new \ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return self::$constCacheArray[$calledClass];
    }

    public static function isValidName($name, bool $strict = false)
    {
        $constants = self::getConstList();
        if (true === $strict) {
            return array_key_exists($name, $constants);
        }
        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys, true);
    }

    public static function isValidValue($value): bool
    {
        $values = array_values(self::getConstList());
        return in_array($value, $values, true);
    }
}