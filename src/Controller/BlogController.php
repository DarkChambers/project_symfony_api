<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

//use annotations to define route and parameters
/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{

    private const POSTS = [
        [
            'id' => 1,
            'slug' => "hello-world",
            'title' => "hello world",
        ],
        [
            'id' => 2,
            'slug' => "another-post",
            'title' => "another post",
        ],      [
            'id' => 3,
            'slug' => "last_example",
            'title' => "this is the last exemple",
        ],
    ];
    /**
     * @Route("/", name="blog_list")
     */
    public function list()
    {
        return new JsonResponse(self::POSTS);
    }
    /**
     * @Route("/{id}",name="blog_by_id")
     */
    public function post($id)
    {
        return new JsonResponse(array_search($id, array_column(self::POSTS, 'id')));
    }
    /**
     * @Route("/{slug}",name="blog_by_slug")
     */
    public function postBySlug($slug)
    {
        return new JsonResponse(array_search($slug, array_column(self::POSTS, 'slug')));
    }
}
