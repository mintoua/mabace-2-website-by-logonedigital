<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Service;
use App\Entity\ServiceCategory;
use App\Form\ClientType;
use App\Services\DefaultService;
use Doctrine\ORM\EntityManagerInterface;
use Flasher\Prime\FlasherInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    public function __construct (
        private EntityManagerInterface $entityManager,
        private DefaultService $defaultService
    )
    {}

    #[Route('/petites-annonces', name: 'app_services')]
    public function index(Request $request): Response
    {
        $client = new Client();

        $form = $this->createForm(ClientType::class,$client);
        $_services = $this->entityManager->getRepository (Service::class)->findAll ();

        $cat = $request->get("catSlug", 'Tous');
        if ( $request -> get ( 'ajax' ) ){

            if ($cat != 'Tous' ){

                $_services = $this->entityManager->getRepository (Service::class)
                    ->findAllServicesByCategory($cat);

                return new JsonResponse([
                    'content'=> $this->renderView ('annonce/serviceList.html.twig',[
                        'services'=> $this->defaultService->toPaginate ($_services, $request, 9 )
                    ])
                ]);
            }
            else{
                return new JsonResponse([
                    'content'=> $this->renderView ('annonce/serviceList.html.twig',[
                        'services'=> $this->defaultService->toPaginate ($_services, $request, 9 )
                    ])
                ]);
            }
        }

        $categoriesServices = $this->entityManager->getRepository (ServiceCategory::class)->findAll ();

        $services = $this->defaultService->toPaginate ( $_services, $request, 9 );
        return $this->render('annonce/services.html.twig',[
            'services'=>$services,
            'categoriesServices'=>$categoriesServices,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/petites-annonces/{slug}', name: 'app_services_apply')]
    public function apply(Request $request, $slug)
    {
        $client = new Client();

        $form = $this->createForm(ClientType::class,$client);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            dd ($client);
        }
        return $this->render('annonce/modal.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
