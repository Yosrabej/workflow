<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Controller\CommandeWorkflowsHandler;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="passer_commande")
     */
    public function passerCommande(): Response
    {

        $manager = $this->getDoctrine()->getManager();
        $commande = new Commande();
        if (isset($_POST['passer_commande'])) {
            $commande->setStatut('passée');
            $commande->setPaiement('nonValidé');
            $manager->persist($commande);
            $manager->flush();
        }
        $commande = $this->getDoctrine()->getRepository(Commande::class);
        // return $this->redirectToRoute('expediee', ['id' => $prod->getId()]);
        return $this->render('commande/index.html.twig', [
            'commande' => $commande,
        ]);
    }
    /**
     * @Route("/pay/{id}", name="commande_pay")
     */
    public function pay($id): Response
    {
        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);

        return $this->render('commande/pay.html.twig', ["commande" => $commande]);
    }

    /**
     * @Route("/ship/{id}", name="commande_ship")
     */
    public function ship($id)
    {
        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);
        return $this->render('commande/ship.html.twig', ["commande" => $commande]);
    }
    /**
     * @Route("/deliver/{id}", name="commande_deliver")
     */
    public function deliver($id)
    {
        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);
        return $this->render('commande/pay.html.twig', ["commande" => $commande]);
    }

    /**
     * @Route("/reject/{id}", name="commande_reject")
     */
    public function reject($id)
    {
        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);
        return $this->render('commande/pay.html.twig', ["commande" => $commande]);
    }

    /**
     * @Route("/annuler/{id}", name="commande_annuler")
     */
    public function annuler($id)
    {
        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);
        return $this->render('commande/pay.html.twig', ["commande" => $commande]);
    }
    /**
     * @Route("/workflow/{statut}/{id}", name="commande_workflow")
     */
    public function workflow($statut, Commande $commande, CommandeWorkflowsHandler $awh, Request $request)
    { // Traitement du Workflow
        try {
            $awh->handle($commande, $statut);
        } catch (LogicException $e) {
            // Notification
            $this->addFlash(
                'error',
                'Changement de statut impossible.'
            );
        }
        // On redirige l'utilisateur sur la bonne page
        return $this->redirectToRoute('commande_pay',  ['id' => $commande->getId()]);
    }





    /** 
     * @Route("/historique", name="historique")
     */
    public function historique()
    {
        $commande = $this->getDoctrine()->getRepository(Commande::class)->findAll();

        return $this->render('commande/historique.html.twig', ["commande" => $commande]);
    }
}
