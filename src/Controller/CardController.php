<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card")
     * @param Request $request
     * @return Response
     */
    public function card(Request $request,EntityManagerInterface $entityManager)
    {
        $em = $this->getDoctrine()->getManager();

        $card = new Card();
        $formCard = $this->createForm(CardFormType::class, $card);

        $cards = $em->getRepository(Card::class)->findAll();

        $formCard->handleRequest($request);
        if ($formCard->isSubmitted() && $formCard->isValid()) {
            $card->setCreator($this->getUser());
            $image = $formCard->get('image')->getData();

            $imageName = 'card-'.uniqid().'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('cards_folder'),
                $imageName
            );
            $card->setImage($imageName);

            $entityManager->persist($card);
            $entityManager->flush();

        }

        return $this->render('card/index.html.twig', [
            'cards' => $cards,
            'form' => $formCard->createView()
        ]);
    }


    /**
     * @Route("/listcard", name="listcard")
     * @param Request $request
     * @return Response
     */
    public function listCard(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $listCard = $em->getRepository(Card::class)->findAll();

        //$->handleRequest($request);
        return $this->render("card/listCard.html.twig", [
            'controller_name' =>'CardController',
            'cards' => $listCard,
    ]);
    }


    public function delete(Card $card, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($card);
        $entityManager->flush();

        return $this->render("card/listCard.html.twig");
    }

}
