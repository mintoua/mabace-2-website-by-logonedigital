<?php

namespace App\Controller;

use App\Entity\Tontine;
use App\Form\TontineType;
use App\Repository\TontineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Flasher\Prime\FlasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TontineController extends AbstractController
{
    public function __construct(
        private TontineRepository $tontineRepo,
        private EntityManagerInterface $em,
        private FlasherInterface $flasher,
    )
    {
        
    }
    

    #[Route("/dashoard/tontine", name:"apps_dashboard_tontine")]
    public function totine():Response{
       //dd($this->tontineRepo->findAll());
        return $this->render("espace-comptable/tontine/tontine.html.twig",[
            "tontines"=>$this->tontineRepo->findAll()
        ]);
    }

    #[Route(path:"/dashboard/tontine/add", name:"app_dashboard_tontine_add")]
    public function addTontine(Request $request):Response{
        $tontine = new Tontine();
        $form = $this->createForm(TontineType::class, $tontine);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $this->em->persist($tontine);
            $this->em->flush();

            $this->flasher->addSuccess("cette tontine à bien été enregistrée");
            return $this->redirectToRoute("apps_dashboard_tontine");
        }

        return $this->render("espace-comptable/tontine/tontine-new.html.twig",[
            "form"=>$form->createView()
        ]);
    }

    #[Route(path:"/dashboard/tontine/delete/{id}", name:"app_dashboard_tontine_delete")]
    public function deleteTontine(Tontine $tontine):Response{
        $this->em->remove($tontine);
        $this->em->flush();
        return $this->redirectToRoute("apps_dashboard_tontine");
    }

    #[Route(path:"/dashboard/tontine/update/{id}", name:"app_dashboard_tontine_update")]
    public function updateTontine(Tontine $tontine, Request $request):Response{
        $form = $this->createForm(TontineType::class, $tontine);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute("apps_dashboard_tontine");
        }

        return $this->render("espace-comptable/calendrier_benef/calendrier-benef.html.twig",[
            "form"=>$form->createView()
        ]);
    }
}
