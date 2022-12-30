<?php

namespace App\Controller;

use App\Entity\Aide;
use App\Entity\Member;
use App\Form\AideType;
use Flasher\Prime\FlasherInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AideController extends AbstractController
{

    private $doctrine;
    private $flasher;

    public function __construct(ManagerRegistry $doctrine, FlasherInterface $flasher)
    {
        $this->doctrine = $doctrine;
        $this->flasher = $flasher;
    }


    #[Route('/dashboard/aide/', name: 'app_aide_index')]
    /**
     * Summary of index: Query all Aide::class in the db in order to display them in the rendred template
     * @return Response
     */
    public function index(): Response
    {
        $repo = $this->doctrine->getRepository(Aide::class);
        $aides = $repo->findAll();
        return $this->render('espace-comptable/aide/index.html.twig', [
            'aides' => $aides
        ]);
    }



    #[Route('/dashboard/aide/create', name: 'app_aide_create')]

    /**
     * Summary of create: generate and display the Aidetype form, them persiste a new Aide objet in the db
     * @param Request $req
     * @return Response
     */
    public function create(Request $req): Response
    {
        $aide = new Aide();
        $manager = $this->doctrine->getManager();
        $form = $this->createForm(AideType::class, $aide);

        $form->handleRequest($req);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($form->getData());
            $manager->flush();
            $this->flasher->addSuccess("nouvelle aide enregistrée avec success!", "status aide");
            return $this->redirectToRoute("app_dashboard_member");
        }

        return $this->renderForm('espace-comptable/aide/create.html.twig',[
            'form' => $form
        ]);



    }
}
