<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $blogPost = new BlogPost();
        $blogPost->setTitle('a first post !');
        $blogPost->setPublished((new \DateTime('2018-07-01 12:00:00')));
        $blogPost->setContent('du texte');
        $blogPost->setAuthor('Monteil christophe');
        $blogPost->setSlug('a-first-blog');

        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setTitle('a second post !');
        $blogPost->setPublished((new \DateTime('2018-07-01 12:00:00')));
        $blogPost->setContent('du texte 2');
        $blogPost->setAuthor('Monteil christophe');
        $blogPost->setSlug('a-second-blog');

        $manager->persist($blogPost);

        $manager->flush();
    }
}
