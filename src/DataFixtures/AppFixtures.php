<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;
class AppFixtures extends Fixture
{
    /**
     * inject password encoder service
     * password encoder method is define un security.Yaml
     * */
    private $passwordEncoder;
    /**
     * @var \Faker\
     */
    private $faker;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = \Faker\Factory::create();
    }
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
    }

    public function loadBlogPosts(ObjectManager $manager)
    {
        $user = $this->getReference('user_admin');
        for ($i=0; $i<100;$i++){
            $blogPost = new BlogPost();
            $blogPost->setTitle($this->faker->realText(30));
            $blogPost->setPublished($this->faker->datetimeThisYear);
            $blogPost->setContent($this->faker->realText());
            $blogPost->setAuthor($user);
            $blogPost->setSlug('a-first-blog');
    
            $manager->persist($blogPost);
        }





       

        $manager->flush();
    }

    public function loadComments(ObjectManager $manager)
    { }
    public function loadUsers(ObjectManager $manager)
    {
        $user = new User;
        $user->setUsername('admin');
        $user->setEmail('admin@blog.com');
        $user->setName('Monteil christophe');
        //password encryption will be set later
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'test12344'));
        $this->addReference('user_admin', $user);
        $manager->persist($user);
        $manager->flush();
    }
}
