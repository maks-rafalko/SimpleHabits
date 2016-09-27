<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SimpleHabits\Application\Command\AddViolationCommand;
use SimpleHabits\Domain\Model\Abstinence\Abstinence;
use SimpleHabits\Domain\Model\Abstinence\AbstinenceId;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\CreateAbstinenceType;

class AbstinencesController extends Controller
{
    /**
     * @Route("/abstinences", name="abstinences")
     */
    public function listAction()
    {
        // TODO return DTO but not entities (readService? investigate it) ->toArray?
        $userId = $this->getUser()->getId();
        $abstinences = $this->get('app.repository.abstinence')->findByUserId($userId);

        return $this->render('abstinence/list.html.twig', [
            'abstinences' => $abstinences,
        ]);
    }

    /**
     * @Route("/abstinences/create", name="abstinences_create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(CreateAbstinenceType::class, null, ['user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $command = $form->getData();
            $this->get('tactician.commandbus')->handle($command);
        }

        return $this->render('abstinence/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/abstinences/{id}/violate", name="abstinences_violate")
     */
    public function violateAction(Abstinence $abstinence)
    {
        $currentUserId = $this->getUser()->getId();

        if (!$abstinence->getUserId()->equals($currentUserId)) {
            throw $this->createAccessDeniedException();
        }

        $command = new AddViolationCommand($abstinence->getId());
        $this->get('tactician.commandbus')->handle($command);

        return $this->redirectToRoute('abstinences');
    }
}
