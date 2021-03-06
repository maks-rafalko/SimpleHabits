<?php

namespace SimpleHabits\Domain\Model\Goal;

class GoalStepTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GoalStep
     */
    private $goalStep;

    protected function setUp()
    {
        $this->goalStep = new GoalStep(new GoalStepId(), 100, new \DateTimeImmutable());
    }

    /**
     * @test
     */
    public function it_correctly_returns_id()
    {
        $id = $this->goalStep->getId();

        $this->assertInstanceOf(GoalStepId::class, $id);
    }

    /**
     * @test
     */
    public function it_correctly_returns_value()
    {
        $value = $this->goalStep->getValue();

        $this->assertEquals(100, $value);
    }

    /**
     * @test
     */
    public function it_correctly_returns_recorded_at_date()
    {
        $recordedAt = $this->goalStep->getRecordedAt();

        $this->assertInstanceOf(\DateTimeInterface::class, $recordedAt);
    }
}
