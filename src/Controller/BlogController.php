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
    //define a default value for parameters, use php bin\console debug:router to see routes

    /**
     * @Route("/{page}", name="blog_list", defaults={"page":5})
     */
    public function list($page = 1)
    {
        return new JsonResponse(
            [
                'page' => $page,
                'data' => array_map(
                    function ($item) {
                        return $this->generateUrl('blog_by_slug', ['slug' => $item['slug']]);
                    },
                    self::POSTS
                )
            ]
        );
    }

    //make different route by requirements
    /**
     * @Route("/{id}",name="blog_by_id", requirements={"id"="\d+"})
     */
    public function post($id)
    {
        return new JsonResponse(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }
    /**
     * @Route("/{slug}",name="blog_by_slug")
     */
    public function postBySlug($slug)
    {
        return new JsonResponse(
            self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]
        );
    }
}
