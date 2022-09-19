<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\ProjetRepository;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SitemapController extends AbstractController
{   
    public function __construct(
    private PostRepository $postRepo,
    private ServiceRepository $serviceRepo,
    private ProjetRepository $projetRepo
    )
    {
        
    }

    #[Route('/sitemap.xml', name: 'app_sitemap', defaults: ["_format"=>"xml"])]
    public function index(Request $request): Response
    {
        $hostname = $request->getSchemeAndHttpHost();
        $urls = [];

        $urls []= ['loc'=> $this->generateUrl("app_home"),"priority"=>0.9];
        $urls []= ['loc'=> $this->generateUrl("app_about"),"priority"=>0.8];
        $urls []= ['loc'=> $this->generateUrl("app_services"),"priority"=>0.9];
        $urls []= ['loc'=> $this->generateUrl("app_cgu"),"priority"=>0.7];
        $urls []= ['loc'=> $this->generateUrl("app_contact"),"priority"=>0.8];
        $urls []= ['loc'=> $this->generateUrl("app_projet"),"priority"=>0.9,];
        // $urls []= ['loc'=> $this->generateUrl("app_category_job"),"priority"=>0.9,];
        
        //ajout des urls dynamique
        foreach($this->postRepo->findAll() as $post){
            $images = [
                "loc" => "/public/uploads/images/BlogImages/".$post->getImage(),
                "title"=>$post->getSlug()
            ];
            $urls []= [
                "loc"=>$this->generateUrl("app_blog_detail", [
                    "slug"=>$post->getSlug()
                ]),
                'images' => $images,
                "priority"=>0.9,
                "changefreq"=>"monthly",
                "lastmod" =>$post->getUpdatedAt() ? $post->getUpdatedAt()->format('Y-m-d') :$post->getCreatedAt()->format('Y-m-d')
            ];
        }
        foreach($this->serviceRepo->findAll() as $service){
            $images = [
                "loc" => "/public/uploads/images/ServiceImages/".$service->getImage(),
                "title"=>$service->getSlug()
            ];
            $urls []= [
                "loc"=>$this->generateUrl("app_services_apply", [
                    "slug"=>$service->getSlug()
                ]),
                'images' => $images,
                "priority"=>0.9,
                "changefreq"=>"monthly",
                "lastmod" =>$post->getCreatedAt()->format('Y-m-d')
            ];
        }
        foreach($this->projetRepo->findAll() as $projet){
            $images = [
                "loc" => "/public/uploads/images/ProjetsImages/".$projet->getImage(),
                "title"=>$projet->getSlug()
            ];
            $urls []= [
                "loc"=>$this->generateUrl("app_projet_detail", [
                    "slug"=>$projet->getSlug()
                ]),
                'images' => $images,
                "priority"=>0.9,
                "changefreq"=>"monthly",
                "lastmod" =>$projet->getCreatedAt()->format('Y-m-d')
            ];
        }
       

        $response = new Response(
            $this->renderView('sitemap/index.html.twig', ['urls' => $urls,
                'hostname' => $hostname]),
            200
        );

        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
