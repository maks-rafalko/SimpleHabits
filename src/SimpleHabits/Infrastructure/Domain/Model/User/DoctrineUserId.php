<?php

namespace SimpleHabits\Infrastructure\Domain\Model\Violation;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use SimpleHabits\Domain\Model\User\UserId;

/**
 * Class DoctrineUserId.
 */
class DoctrineUserId extends GuidType
{
    /**
     * @param $value
     * @param AbstractPlatform $platform
     *
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->id();
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     *
     * @return UserId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new UserId($value);
    }
}
