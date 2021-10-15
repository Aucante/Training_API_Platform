<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostCountController extends AbstractController
{

    /**
     * @var PostRepository
     */
    private PostRepository $postRepository;


    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function __invoke(): int
    {
        return $this->postRepository->count([]);

    }
}
