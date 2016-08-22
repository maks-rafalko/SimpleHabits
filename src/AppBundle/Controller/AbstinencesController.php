<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\CreateAbstinenceType;

class AbstinencesController extends Controller
{
    /**
     * @Route("/abstinences", name="abstinences")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(CreateAbstinenceType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $commandBus = $this->get('tactician.commandbus');

            $command = $form->getData();
            $commandBus->handle($command);
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
