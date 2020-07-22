<?php

namespace App\DataFixtures;

use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\ArticleCategory;
use App\Entity\Comment;
use App\Service\Slugify;

class AppFixtures extends Fixture
{
    private $encoder;

    // ARTICLE CATEGORIES
    const CATEGORIES = [
        'Animals',
        'Cosmos',
        'Magic'
    ];

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('en_US');

        // USERS
        //User
        $user = new User();
        $user->setName($faker->userName);
        $user->setEmail('user@user.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->encoder->encodePassword($user, 'user'));

        $manager->persist($user);

        // Admin
        $admin = new User();
        $admin->setName($faker->firstName);
        $admin->setEmail('admin@admin.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->encoder->encodePassword($admin, 'admin'));

        $manager->persist($admin);

        // Multiple Users
        for($i = 0 ; $i < 10; $i++) {
            $user = new User();
            $user->setName($faker->userName);
            $user->setEmail($faker->email);
            $user->setPassword($this->encoder->encodePassword($user, 'password'));
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }
        
        // ARTICLE CATEGORIES
        foreach (self::CATEGORIES as $key => $categoryName) {
            $category = new ArticleCategory();
            $category->setCategory($categoryName);
            $manager->persist($category);
            $this->addReference('category_' . $key, $category);
        }
        
        // 10 ARTICLES
        for($i = 0 ; $i < 10; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence);
            $article->setSubject($faker->word);
            $article->setContent($faker->text(100));
            $article->setAuthor($faker->name);
            $article->setImage($faker->imageUrl($width = 200, $height = 150));
            $article->setMediaLink('https://www.youtube.com/embed/EeqF6m3MqqY');
            $article->setPublishedAt($faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null));
            $article->setCategory($this->getReference('category_' . $faker->numberBetween(0, 2)));
            $slugify = new Slugify();
            $slug = $slugify->generate($article->getTitle());
            $article->setSlug($slug);
            $manager->persist($article);
        }

        $manager->flush();
    }
}
