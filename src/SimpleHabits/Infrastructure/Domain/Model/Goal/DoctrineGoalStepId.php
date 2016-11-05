<?php

namespace SimpleHabits\Infrastructure\Domain\Model\Goal;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use SimpleHabits\Domain\Model\Goal\GoalStepId;

/**
 * Class DoctrineGoalStepId.
 */
class DoctrineGoalStepId extends GuidType
{
    /**
     * @param $value
     * @param AbstractPlatform $platform
     *
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof GoalStepId) {
            return $value->id();
        }

        return $value;
    }

    /**
     * @param $value
     * @param AbstractPlatform $platform
     *
     * @return GoalStepId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new GoalStepId($value);
    }
}
