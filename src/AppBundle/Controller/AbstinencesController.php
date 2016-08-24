<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\CreateAbstinenceType;

class AbstinencesController extends Controller
{
    /**
     * @Route("/abstinences/create", name="abstinences_create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(CreateAbstinenceType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $commandBus = $this->get('tactician.commandbus');

            $command = $form->getData();
            $commandBus->handle($command);
        }

        return $this->render('abstinence/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/abstinences", name="abstinences")
     */
    public function listAction()
    {
        $abstinences = $this->get('app.repository.abstinence')->findByUserId(1);

        return $this->render('abstinence/list.html.twig', [
            'abstinences' => $abstinences,
        ]);
    }
}
