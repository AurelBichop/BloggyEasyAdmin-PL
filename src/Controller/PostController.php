<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{

    public function __construct(private PostRepository $postRepository){}


    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $posts = $this->postRepository->findAllPublishedOrderedBy();


        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );

        return $this->render('posts/index.html.twig', compact('posts'));
    }

    #[Route(
        '/post/{year}/{month}/{day}/{slug}', 
        requirements:[
            'year' => '\d{4}',
            'month' => '\d{2}',
            'day' => '\d{2}',
            'slug' => '[a-z0-9\-]+'
        ],
        name: 'app_posts_show',
        methods: ['GET'])
     ]
    public function show(int $year,int $month,int $day,string $slug): Response
    {
        $post = $this->postRepository->findOneByPublishDateAndSlug($year,$month,$day,$slug);
        
        return $this->render('posts/show.html.twig', compact('post'));
    }
}
