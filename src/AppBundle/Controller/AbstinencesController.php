<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SimpleHabits\Application\Command\AddViolationCommand;
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
        $abstinences = $this->get('app.repository.abstinence')->findByUserId(1);

        return $this->render('abstinence/list.html.twig', [
            'abstinences' => $abstinences,
        ]);
    }

    /**
     * @Route("/abstinences/create", name="abstinences_create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(CreateAbstinenceType::class);
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
    public function violateAction($id)
    {
        // TODO check that this abstinence is owned by current user

        $command = new AddViolationCommand(new AbstinenceId($id));
        $this->get('tactician.commandbus')->handle($command);

        return $this->redirectToRoute('abstinences');
    }
}
