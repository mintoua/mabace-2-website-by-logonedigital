<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Entity\Member;
use App\Entity\Remboursement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Flasher\Prime\FlasherInterface;
class RemboursementController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $doctrine,
        private EntityManagerInterface $em,
        private FlasherInterface $flasher,
    )
    {}

    #[Route('/dashboard/remboursement', name: 'app_dashboard_remboursements')]
    public function index(): Response
    {
        return $this->render('espace-comptable/remboursement/index.html.twig', [
            'remboursements' => $this->doctrine->getRepository(Remboursement::class)->findAll(),
        ]);
    }

    #[Route('/dashboad/emprunt/ajouter-remboursement/{id}', name: 'app_add_remboursement')]
    public function addRefund(Emprunt $emprunt){

        $refund = new Remboursement();
        $refund->setRefundAt(new \DateTime('now'));
        $refund->setEmprunt($emprunt);
        
        $emprunt->setEtat(1);
        $emprunt->setRemboursement($refund);
        $this->em->persist($refund);
        $this->em->flush();

        $this->flasher->addSuccess("Remboursement Enregistré avec succés");
        return $this->redirectToRoute('app_dashboard_remboursements');
    }

    #[Route('/dashboard/remboursement/supprimer/{id}', name: 'app_delete_remboursement')]
    public function deleteRefund(Remboursement $refund){

        $this->em->remove($refund);
        $this->em->flush();
        $this->flasher->addSuccess("Suppression réussie");
        return $this->redirectToRoute("app_dashboard_remboursements");
    }
}
