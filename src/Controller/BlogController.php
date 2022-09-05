<?php

namespace App\Controller;

use DateInterval;
use App\Entity\Post;
use App\Entity\CategoryPost;
use App\Services\DefaultService;
use App\Repository\PostRepository;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\UrlPackage;
use App\Repository\CategoryPostRepository;
use Sonata\SeoBundle\Seo\SeoPageInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;

class BlogController extends AbstractController
{

    public function __construct(
    private PostRepository $postRepo,
    private CategoryPostRepository $categoryPostRepo,
    private PaginatorInterface $paginator,
    private DefaultService $defaultService,
    private CacheInterface $cache,
    private SeoPageInterface $seoPage,
    private UrlGeneratorInterface $urlGenerator,
    )
    {
        
    }

    #[Route('/blog', name: 'app_blog')]
    public function blog(Request $req): Response
    {  
        $posts = $this->postRepo->findOrder();
        $cat = $req->get("catSlug", 'Tous');
        if ($req->get('ajax')){
            if ($cat != 'Tous' ){
                $posts = $this->postRepo->findAllServicesByCategory($cat);

                return new JsonResponse([
                    'content'=> $this->renderView ('blog/blogList.html.twig',[
                        'posts'=> $this->defaultService->toPaginate ($posts, $req, 2 )
                    ])
                ]);
            }
            else{
                return new JsonResponse([
                    'content'=> $this->renderView ('blog/blogList.html.twig',[
                        'posts'=> $this->defaultService->toPaginate ($posts, $req, 2 )
                    ])
                ]);
            }
        }

       

        /** mise en cache */
        $postsCached = $this->cache->get( 'posts_blog_page' , function ( ItemInterface $item ) use($posts, $req) {
            $item->expiresAfter(DateInterval::createFromDateString('30 days'));
            return $posts;
        });

        

        $categoriesPost = $this->cache->get( 'categories_post_blog_page' , function ( ItemInterface $item ) {
            $item->expiresAfter(DateInterval::createFromDateString('30 days'));
            return $this->categoryPostRepo->findAll();
        });

        /** Début partie SEO */
        $description = "découvrez les annonces de prestations de services chez MA.BA.CA II";
        $this -> seoPage -> setTitle ("Blog")
            -> addMeta ('property','og:title','les petites annonces MA.BA.CE II')
            ->addTitleSuffix("MA.BA.CE.&#x2161")
            ->addMeta('name', 'description', $description)
            ->addMeta('property', 'og:title', "actualités MA.BA.CE.II")
            ->setLinkCanonical($this->urlGenerator->generate('app_blog',[], urlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:url',  $this->urlGenerator->generate('app_blog',[], urlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:description',$description)
            ->setBreadcrumb('Blog', []);
        /** Fin partie SEO */


        return $this->render('blog/blog.html.twig', [
            'posts'=>$this->paginator->paginate($postsCached, $req->query->getInt('page', 1),3),
            "categoriesPost"=>$categoriesPost
        ]);
    }

    #[Route('/blog/article/{slug}', name: 'app_blog_detail')]
    public function blogDetail(Post $post, Request $req): Response
    {   
        
        $this->cache->delete('post_single_blog_page-'.$post->getSlug());
       /** mise en cache */
      ;
        $postCached = $this->cache->get( 'post_single_blog_page_'.$post->getSlug() , function ( ItemInterface $item ) use($post) {
            $item->expiresAfter(DateInterval::createFromDateString('30 days'));
            return $post;
        });
        
        
        //afin de sauvegarder la catégorie du post dans le cache
        $catPost = $this->cache->get( 'post_category_single_blog_page_'.$post->getSlug() , function ( ItemInterface $item ) use($post) {
            $item->expiresAfter(DateInterval::createFromDateString('30 days'));
             
            return $this->categoryPostRepo->findOneBy(['slug'=>$post->getCategoryPost()->getSlug()]);
        });
        
        // dd($catPost);
       

        /**Début partie SEO */
        $urlPackage = new UrlPackage(
            'https://mabace-2.com/uploads/images/BlogImages/'.$post->getImage(),
            new StaticVersionStrategy('v1')
        );

        $urlPackage->getUrl($post->getImage());

        $this -> seoPage -> setTitle ($postCached->getTitle())
            -> addMeta ('property','og:title',$postCached->getTitle())
            ->addMeta('name', 'description', $postCached->getContent())
            ->addTitleSuffix("MA.BA.CE.&#x2161")
            ->addMeta('property', 'og:title', $postCached->getTitle())
            ->setLinkCanonical($this->urlGenerator->generate('app_blog_detail',['slug'=>$postCached->getSlug()], urlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:url',  $this->urlGenerator->generate('app_blog_detail',['slug'=>$postCached->getSlug()], urlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:description',$postCached->getContent())
            ->addMeta('property', 'og:image',$urlPackage->getBaseUrl($post->getImage()))
           ->setBreadcrumb('blog', [
            'post' => $postCached,
            ]);
        /** Fin partie SEO */

        return $this->render('blog/blog-single.html.twig', [
            "post"=>$postCached,
            "catPost"=> $catPost,
            "lastPosts"=>$this->postRepo->lastPosts(),
            "categoriesPost"=>$this->categoryPostRepo->findAll()
        ]);
    }


    #[Route('/blog/thematique/{slug}', name: 'app_blog_by_category')]
    public function blogByCategory(CategoryPost $CategoryPost, Request $req): Response
    {
        
        
        $postsCached = $this->cache->get( 'post_blog_page_by_category' , function ( ItemInterface $item ) 
        use(
        $CategoryPost, 
        $req
        )
        {
            $item->expiresAfter(DateInterval::createFromDateString('30 days'));

            return $this->paginator->paginate($CategoryPost->getPosts(), $req->query->getInt('page', 1),5);
        });

        $CategoryPostCached = $this->cache->get( 'categories_blog_by_category' , function ( ItemInterface $item ) 
        use($CategoryPost)
        {
            $item->expiresAfter(DateInterval::createFromDateString('30 days'));

            return $CategoryPost;
        });

         /**Début partie SEO */
        $this -> seoPage -> setTitle ($CategoryPostCached->getDesignation())
            -> addMeta ('property','og:title',$CategoryPostCached->getDesignation())
            // ->addMeta('name', 'description', $postCached->getContent())
            ->addTitleSuffix("MA.BA.CE.&#x2161")
            ->addMeta('property', 'og:title', $CategoryPostCached->getDesignation())
            ->setLinkCanonical($this->urlGenerator->generate('app_blog_by_category',['slug'=>$CategoryPostCached->getSlug()], urlGeneratorInterface::ABSOLUTE_URL))
            ->addMeta('property', 'og:url',  $this->urlGenerator->generate('app_blog_by_category',['slug'=>$CategoryPostCached->getSlug()], urlGeneratorInterface::ABSOLUTE_URL))
            // ->addMeta('property', 'og:description',$postCached->getContent())
            // ->addMeta('property', 'og:image',$urlPackage->getBaseUrl($post->getImage()))
           ->setBreadcrumb('blog', [
            'blog' => $CategoryPostCached,
            ]);
        /** Fin partie SEO */

        return $this->render('blog/blog-by-category.html.twig', [
            "CategoryPost"=>$CategoryPostCached,
            "posts"=>$postsCached
        ]);
    }
}
