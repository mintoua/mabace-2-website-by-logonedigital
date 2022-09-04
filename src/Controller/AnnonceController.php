<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Service;
use App\Entity\ServiceCategory;
use App\Form\ClientType;
use App\Services\DefaultService;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\SeoBundle\Seo\SeoPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AnnonceController extends AbstractController
{
    public function __construct (
        private EntityManagerInterface $entityManager,
        private DefaultService $defaultService,
        private SeoPageInterface $seoPage,
    )
    {}

    #[Route('/petites-annonces', name: 'app_services')]
    public function index(Request $request): Response
    {

        $_services = $this->defaultService->toCache ('services','1 day',
            $this->entityManager->getRepository (Service::class)->findAll ());
        $categoriesServices = $this->defaultService->toCache ('service_categories','1 day',
            $this->entityManager->getRepository (ServiceCategory::class)->findAll ());
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


        $description = "découvrez les annonces de prestations de services chez MA.BA.CA II";
        $this -> seoPage -> setTitle ( "les petites annonces MA.BA.CE II" )
            -> addMeta ( 'property' , 'og:title' , '' )
            ->addMeta('name', 'description', $description)
            ->addMeta('name', 'keywords', "mabace2, association,")
            ->addMeta('property', 'og:title', "petites annonces MA.BA.CE II")
            ->setLinkCanonical($this->urlGenerator->generate('app_services',[], urlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:url',  $this->urlGenerator->generate('app_services',[], urlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:description',$description)
            ->setBreadcrumb('Services', []);



        $services = $this->defaultService->toPaginate ( $_services, $request, 9 );
        return $this->render('annonce/services.html.twig',[
            'services'=>$services,
            'categoriesServices'=>$categoriesServices,
        ]);
    }

    #[Route('/petites-annonces/{slug}', name: 'app_services_apply')]
    public function apply(Request $request, Service $service)
    {
        $client = new Client();

        $form = $this->createForm(ClientType::class,$client);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $client->addService ($service);
            $this->entityManager->persist ($client);
            $this->entityManager->flush ();
            return $this->redirectToRoute('app_services');
        }



        return $this->render('annonce/apply.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
