<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Form\CreateViolationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use SimpleHabits\Domain\Model\Abstinence\Abstinence;
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
     * @Route("/abstinences/{id}", name="abstinence", requirements={"id": "[\da-z\-]{36}"})
     * @Security("user.getId().equals(abstinence.getUserId())")
     */
    public function viewAction(Abstinence $abstinence)
    {
        return $this->render('abstinence/view.html.twig', [
            'abstinence' => $abstinence,
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

            return $this->redirectToRoute('abstinences');
        }

        return $this->render('abstinence/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/abstinences/{id}/violations/new", name="abstinences_violates_new", methods={"GET"})
     * @Security("user.getId().equals(abstinence.getUserId())")
     */
    public function addViolationAction(Abstinence $abstinence, Request $request)
    {
        $form = $this->createForm(CreateViolationType::class, null, [
            'action' => $this->generateUrl('abstinences_violate', ['id' => $abstinence->getId()]),
        ]);
        $form->handleRequest($request);

        return $this->render('abstinence/add-violation.html.twig', [
            'abstinence' => $abstinence,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/abstinences/{id}/violations", name="abstinences_violate", methods={"POST"})
     * @Security("user.getId().equals(abstinence.getUserId())")
     */
    public function violateAction(Abstinence $abstinence, Request $request)
    {
        $form = $this->createForm(CreateViolationType::class, null, ['abstinence' => $abstinence]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $command = $form->getData();
            $this->get('tactician.commandbus')->handle($command);

            return $this->redirectToRoute('abstinences');
        }

        return $this->render('abstinence/add-violation.html.twig', [
            'abstinence' => $abstinence,
            'form' => $form->createView(),
        ]);
    }
}
