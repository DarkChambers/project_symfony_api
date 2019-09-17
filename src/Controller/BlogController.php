<?php

namespace App\Controller;

use App\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

//use annotations to define route and parameters
/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{


    //define a default value for parameters, use php bin\console debug:router to see routes
    //handle parameters from url by Request
    //symfony must return a Response like Object
    //Do not forger to add a requirement to distinct the route from the add route which received a parameters too
    //add property_info : true to config

    /**
     * @Route("/{page}", name="blog_list", defaults={"page":5}, requirements={"page"="\d+"})
     */
    public function list($page = 1, Request $request)
    {

        $limit = $request->get('limit', 10);
        $repository = $this->getDoctrine()->getRepository(BlogPost::class);
        $items = $repository->findAll();
        return $this->json(
            [
                'page' => $page,
                'limit' => $limit,
                'data' => array_map(
                    function (BlogPost $item) {
                        return $this->generateUrl('blog_by_slug', ['slug' => $item->getSlug()]);
                    },
                    $items
                )
            ]
        );
    }

    //make different route by requirements
    /**
     * @Route("/post/{id}",name="blog_by_id", requirements={"id"="\d+"},methods={"GET"})
     * @ParamConverter("post", class="App:BlogPost")
     */
    public function post($post)
    {
        //     return $this->json(
        //         $this->getDoctrine()->getRepository(BlogPost::class)->find($id)
        //     );
        return $this->json($post);
    }

    /**
     * @Route("/post/{slug}",name="blog_by_slug",methods={"GET"})
     * The beow annotation is not required when $post is typehinted with BlogSpot 
     * and route parameter name matches any field on the BlogSpost entity
     * @ParamConverter("post",class="App:BlogPost", options={"mapping":{"slug":"slug"}})
     */
    public function postBySlug(BlogPost $post)
    {

        return $this->json($post);
        // return $this->json(
        //     $this->getDoctrine()->getRepository(BlogPost::class)->findOneBy(['slug'=>$slug])
        // );
    }

    /**
     * @Route("/add", name="blog_add", methods={"POST"})
     */
    public function add(Request $request)
    {
        /**
         * @var Serializer $serializer
         */
        $serializer = $this->get('serializer');
        $blogPost = $serializer->deserialize($request->getContent(), BlogPost::class, 'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($blogPost);
        $em->flush();
        return $this->json($blogPost);
    }

/**
 * @Route("/post/{id}", name="blog_delete", methods={"DELETE"})
 */
    public function delete(BlogPost $post){
        $em=$this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return new JsonResponse(null,Response::HTTP_NO_CONTENT);
        }
}
