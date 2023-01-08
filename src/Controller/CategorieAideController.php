<?php

namespace App\Controller;

use App\Entity\CategorieAide;
use App\Form\CategorieAideType;
use App\Repository\CategorieAideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Flasher\Prime\FlasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieAideController extends AbstractController
{

    public function __construct(
        private CategorieAideRepository $categorieAideRepository,
        private EntityManagerInterface $em,
        private FlasherInterface $flasher,
    )
    {
        
    }

    #[Route('dashboard/type_aide/list', name: 'app_dashboard_categorie_aide')]
    public function listAllCategoriesAide(): Response
    {

        return $this->render('espace-comptable/categorie_aide/list_categorie_aide.html.twig', [
            'aides' => $this->categorieAideRepository->findAll(),
        ]);
    }

    #[Route(path:"/dashboard/type_aide/new", name:"app_dashboard_categorie_aide_new")]
    public function addCategorieAide(Request $request):Response{
        $categorieAide = new CategorieAide();
        $form = $this->createForm(CategorieAideType::class, $categorieAide);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $this->em->persist($categorieAide);
            $this->em->flush();
            $this->flasher->addSuccess("Cette catégorie d'aide a bien été prise en compte");
            return $this->redirectToRoute("app_dashboard_categorie_aide");
        }

        return $this->render("espace-comptable/categorie_aide/new_categorie_aide.html.twig",[
            "form"=>$form->createView()
        ]);
    }

    #[Route(path:"/dashoard/type_aide/edit/{id}", name:"app_dashboard_categorie_aide_edit")]
    public function editCategorieAide(Request $request, CategorieAide $categorieAide):Response{
        $form = $this->createForm(CategorieAideType::class, $categorieAide);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $this->em->persist($categorieAide);
            $this->em->flush();
            $this->flasher->addSuccess("Cette catégorie d'aide a bien été modifiée");
            return $this->redirectToRoute("app_dashboard_categorie_aide");
        }

        return $this->render("espace-comptable/categorie_aide/edit_categorie_aide.html.twig",[
            "form"=>$form->createView()
        ]);
    }

    #[Route(path:"/dashoard/type_aide/delete/{id}", name:"app_dashboard_categorie_aide_delete")]
    public function deleteCategorieAide(CategorieAide $categorieAide):Response{
        $this->em->remove($categorieAide);
        $this->em->flush();
        $this->flasher->addSuccess("Cette catégorie d'aide a bien été supprimée");
        return $this->redirectToRoute("app_dashboard_categorie_aide");
    }
}
