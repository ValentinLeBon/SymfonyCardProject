<?php

namespace App\Controller;

use App\Entity\Faction;
use App\Form\FactionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FactionController extends AbstractController
{
    /**
     * @Route("/faction", name="faction")
     * @param Request $request
     * @return Response
     */
    public function faction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $faction = new Faction();
        $formFaction = $this->createForm(FactionFormType::class, $faction);;

        $formFaction->handleRequest($request);

        if ($formFaction->isSubmitted() && $formFaction->isValid()) {
            $em->persist($faction);
            $em->flush();
            $this->addFlash('notice', "Faction ajoutée");
            return $this->redirectToRoute('card');
        }

        return $this->render('card/index.html.twig', [
            'cards' => $faction,
            'form' => $formFaction->createView()
        ]);
    }
        /**
         * @Route("/factionlist", name="factionlist")
         * @param Request $request
         */
    public function listFaction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        }
}
