<?php

namespace App\DBAL;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType;

class ImmutableDatetimeType extends DateTimeType
{
    const IMMUTABLE_DATETIME = 'immutable_datetime';

    public function getName()
    {
        return static::IMMUTABLE_DATETIME;
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return \DateTime|false|mixed
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $result = parent::convertToPHPValue($value, $platform);

        if ($result instanceof \DateTime) {
            return \DateTimeImmutable::createFromMutable($result);
        }

        return $result;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

}