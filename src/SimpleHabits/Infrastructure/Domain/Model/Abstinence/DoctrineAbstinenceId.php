<?php

namespace SimpleHabits\Infrastructure\Domain\Model\Abstinence;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;

/**
 * Class DoctrineAbstinenceId
 * @package SimpleHabits\Infrastructure\Domain\Model\Abstinence
 */
class DoctrineAbstinenceId extends GuidType
{
    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->id();
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return AbstinenceId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new AbstinenceId($value);
    }
}