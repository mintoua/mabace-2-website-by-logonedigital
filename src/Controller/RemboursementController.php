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

    #[Route('/dashboad/emprunt/update-remboursement/{id}', name: 'app_update_remboursement')]
    public function addRefund(Remboursement $echeance){

        $echeance->setEtat(1);
        $this->em->flush();

        $this->flasher->addSuccess("Remboursement Enregistré avec succés");
        return $this->redirectToRoute('app_dashboard_emprunt_single',["id"=>$echeance->getEmprunt()->getId()]);
    }

    #[Route('/dashboard/remboursement/supprimer/{id}', name: 'app_delete_remboursement')]
    public function deleteRefund(Remboursement $refund){

        $this->em->remove($refund);
        $this->em->flush();
        $this->flasher->addSuccess("Suppression réussie");
        return $this->redirectToRoute("app_dashboard_remboursements");
    }
}
