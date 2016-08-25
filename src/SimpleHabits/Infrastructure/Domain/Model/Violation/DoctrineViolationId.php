<?php

namespace SimpleHabits\Infrastructure\Domain\Model\Abstinence;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use SimpleHabits\Domain\Model\Violation\ViolationId;

/**
 * Class DoctrineViolationId.
 */
class DoctrineViolationId extends GuidType
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
     * @return ViolationId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new ViolationId($value);
    }
}
