<?php

namespace App\Controller;


use App\Entity\Commande;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager as PersistenceObjectManager;
use Symfony\Component\Workflow\Exception\LogicException;
use Symfony\Component\Workflow\Registry;

class CommandeWorkflowsHandler
{

    private $workflows, $manager;

    public function __construct(Registry $workflows, EntityManagerInterface $manager)
    {
        $this->workflows = $workflows;
        $this->manager = $manager;
    }
    public function handle(Commande $commande, string $statut): void
    {
        //Récupération du Workflow
        $workflow = $this->workflows->get($commande);
        // Récupération de Doctrine
        $em = $this->manager;
        // Changement du Workflow
        $workflow->apply($commande, $statut);
        // Insertion en BDD
        $em->flush();
        // 

        if ($workflow->can($commande, 'deliver')) {
            $workflow->apply($commande, 'deliver');
            $em->flush();
        }
    }
}
