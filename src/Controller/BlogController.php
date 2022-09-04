<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\CategoryPost;
use App\Repository\PostRepository;
use App\Repository\CategoryPostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{

    public function __construct(
    private PostRepository $postRepo,
    private CategoryPostRepository $categoryPostRepo,
    private PaginatorInterface $paginator,
    )
    {
        
    }

    #[Route('/blog', name: 'app_blog')]
    public function blog(Request $req): Response
    {  

        $posts = $this->paginator->paginate($this->postRepo->findOrder(), $req->query->getInt('page', 1),9);

        return $this->render('blog/blog.html.twig', ['posts'=>$posts]);
    }

    #[Route('/blog/article/{slug}', name: 'app_blog_detail')]
    public function blogDetail(Post $post): Response
    {
        return $this->render('blog/blog-single.html.twig', [
            "post"=>$post,
            "lastPosts"=>$this->postRepo->lastPosts(),
            "categoriesPost"=>$this->categoryPostRepo->findAll()
        ]);
    }


    #[Route('/blog/thematique/{slug}', name: 'app_blog_by_category')]
    public function blogByCategory(CategoryPost $CategoryPost, Request $req): Response
    {
        
        $posts = $this->paginator->paginate($CategoryPost->getPosts(), $req->query->getInt('page', 1),5);
        return $this->render('blog/blog-by-category.html.twig', [
            "CategoryPost"=>$CategoryPost,
            "posts"=>$posts
        ]);
    }
}
