<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);


    }

    public function loadBlogPosts(ObjectManager $manager)
    {
        $user=$this->getReference('user_admin');
        $blogPost = new BlogPost();
        $blogPost->setTitle('a first post !');
        $blogPost->setPublished((new \DateTime('2018-07-01 12:00:00')));
        $blogPost->setContent('du texte');
        $blogPost->setAuthor($user);
        $blogPost->setSlug('a-first-blog');

        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setTitle('a second post !');
        $blogPost->setPublished((new \DateTime('2018-07-01 12:00:00')));
        $blogPost->setContent('du texte 2');
        $blogPost->setAuthor($user);
        $blogPost->setSlug('a-second-blog');

        $manager->persist($blogPost);

        $manager->flush();
    }

    public function loadComments(ObjectManager $manager)
    {

    }
    public function loadUsers(ObjectManager $manager)
    {
$user = new User;
$user->setUsername('admin');
$user->setEmail('admin@blog.com');
$user->setName('Monteil christophe');
//password encryption will be set later
$user->setPassword('test1234');
$this->addReference('user_admin', $user);
$manager->persist($user);
$manager->flush();

    }
}
