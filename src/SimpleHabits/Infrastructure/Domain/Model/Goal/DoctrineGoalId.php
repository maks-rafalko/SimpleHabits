<?php

namespace SimpleHabits\Infrastructure\Domain\Model\Goal;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use SimpleHabits\Domain\Model\Goal\GoalId;

/**
 * Class DoctrineGoalId.
 */
class DoctrineGoalId extends GuidType
{
    /**
     * @param $value
     * @param AbstractPlatform $platform
     *
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof GoalId) {
            return $value->id();
        }

        return $value;
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     *
     * @return GoalId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new GoalId($value);
    }
}
