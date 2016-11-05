<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Form\AddGoalStepType;
use AppBundle\Form\CreateGoalType;
use AppBundle\Form\RemoveGoalType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SimpleHabits\Application\Command\Goal\RemoveGoalCommand;
use SimpleHabits\Domain\Model\Goal\Goal;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GoalController extends Controller
{
    /**
     * @Route("/goals", name="goals")
     */
    public function listAction()
    {
        $userId = $this->getUser()->getId();
        $goals = $this->get('app.repository.goal')->findByUserId($userId);

        return $this->render('goal/list.html.twig', [
            'goals' => $goals,
            'deleteForms' => $this->buildDeleteForms($goals),
        ]);
    }

    /**
     * @Route("/goals/{id}", name="goal", requirements={"id": "[\da-z\-]{36}"})
     * @Security("user.getId().equals(goal.getUserId())")
     */
    public function viewAction(Goal $goal)
    {
        return $this->render('goal/view.html.twig', [
            'goal' => $goal,
        ]);
    }

    /**
     * @Route("/goals/create", name="goals_create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(CreateGoalType::class, null, ['user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $command = $form->getData();
            $this->get('tactician.commandbus')->handle($command);

            $this->addFlash('notice', 'Goal has been created.');

            return $this->redirectToRoute('goals');
        }

        return $this->render('goal/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/goals/{id}/goal-steps/new", name="goals_steps_new", methods={"GET"})
     * @Security("user.getId().equals(goal.getUserId())")
     */
    public function addGoalStepAction(Goal $goal, Request $request)
    {
        $form = $this->createForm(AddGoalStepType::class, null, [
            'goal' => $goal,
            'action' => $this->generateUrl('goals_add_step', ['id' => $goal->getId()]),
        ]);
        $form->handleRequest($request);

        return $this->render('goal/add-step.html.twig', [
            'goal' => $goal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/goals/{id}/steps", name="goals_add_step", methods={"POST"})
     * @Security("user.getId().equals(goal.getUserId())")
     */
    public function createStepAction(Goal $goal, Request $request)
    {
        $form = $this->createForm(AddGoalStepType::class, null, ['goal' => $goal]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $command = $form->getData();
            $this->get('tactician.commandbus')->handle($command);

            $this->addFlash('notice', 'Step has been added to the Goal.');

            return $this->redirectToRoute('goals');
        }

        return $this->render('goal/add-step.html.twig', [
            'goal' => $goal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/goals/{id}/remove", name="goals_remove", methods={"DELETE"})
     * @Security("user.getId().equals(goal.getUserId())")
     */
    public function removeAction(Goal $goal)
    {
        $command = new RemoveGoalCommand($goal->getId());

        $this->get('tactician.commandbus')->handle($command);

        $this->addFlash('notice', 'Goal has been removed.');

        return $this->redirectToRoute('goals');
    }

    /**
     * @param array $goals
     * @return array
     */
    private function buildDeleteForms(array $goals) : array
    {
        $deleteForms = [];
        foreach ($goals as $goal) {
            $form = $this
                ->createForm(
                    RemoveGoalType::class,
                    $goal,
                    ['action' => $this->generateUrl('goals_remove', ['id' => $goal->getId()])]
                )
                ->createView();

            $deleteForms[$goal->getId()->id()] = $form;
        }
        return $deleteForms;
    }
}
