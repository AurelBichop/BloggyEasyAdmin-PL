<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{

    public function __construct(private PostRepository $postRepository){}


    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAllPublishedOrderedBy();

        return $this->render('posts/index.html.twig', compact('posts'));
    }

    #[Route(
        '/post/{year}/{month}/{day}/{slug}', 
        requirements:[
            'year' => '\d{4}',
            'month' => '\d{2}',
            'day' => '\d{2}'
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
