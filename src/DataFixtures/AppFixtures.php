<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\ArticleCategory;
use App\Entity\Comment;
use App\Entity\RapperCard;
use App\Entity\OracleCard;

class AppFixtures extends Fixture
{
    private $encoder;

    // ARTICLE CATEGORIES
    const CATEGORIES = [
        'Music',
        'Cosmos',
        'Magic'
    ];

    //RAPPERS
    const RAPPERS = [
        'Kota The Friend' => [
            'quote' => "Don't wanna love if it ain't right.",
            'track' => "Long Beach",
            'image' => "https://lh3.googleusercontent.com/proxy/T8HEXI6BStlMhpiVa8Qgz2BRz48ctQ0QVQIpQ0jhIUnQPenI_5tLJGE67uPgrQPx7AXTor43xOMe_GkQ6NHyS79Eb8H6___BjBe1D8CqbXlcWKlptRYRbg1uBg9lbzdjPpMzMyc"
        ],
        'J.I.D' => [
            'quote' => "But when I'm good, I'm good, when I'm bad, I'm better.",
            'track' => "Just Da Other Day",
            'image' => "https://pbs.twimg.com/media/DoxWq9XXoAIpxWo.jpg"
        ],
        'ASAP Ant' => [
            'quote' => "Look at my clothes. Look at my bitch, she got the white toes.",
            'track' => "Shangai",
            'image' => "https://img.discogs.com/AM9VlqADHtmfv6gKVW4pVEpifUA=/494x494/smart/filters:strip_icc():format(jpeg):mode_rgb():quality(90)/discogs-images/A-2898552-1365074639-6195.jpeg.jpg"
        ],
        'AKTHESAVIOR' => [
            'quote' => "My only competition when I’m looking in the mirror.",
            'track' => "Piccolo",
            'image' => "https://images.genius.com/8998fb21a1f3a447bc6ee84b391aa544.720x720x1.jpg"
        ],
        'Sat de la Fonky Family' => [
            'quote' => "Y’a aussi de l’amour partout, même dans mon rap même si tu veux pas le voir.",
            'track' => "Art de Rue",
            'image' => "https://images.genius.com/42b34e60e4c5f3413d6ed5bd255fe08e.400x403x1.jpg"
        ]
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
            $this->addReference('author_' . $i, $user);
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
            $article->setImage('https://media.giphy.com/media/l2LoK2PEoeSLGaaZFc/giphy.gif');
            $article->setMediaLink('https://www.youtube.com/embed/EeqF6m3MqqY');
            $article->setPublishedAt($faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null));
            $article->setCategory($this->getReference('category_' . $faker->numberBetween(0, 2)));
            $manager->persist($article);
            $this->addReference('article_' . $i, $article);
        }

        // 70 COMMENTS
        for ($i = 0; $i < 70; $i++) {
            $comment = new Comment();
            $comment->setComment($faker->text);
            $comment->setPostedAt($faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null));
            for ($b = 0; $b < 10; $b++) {
                $comment->setAuthor($this->getReference('author_' . $faker->numberBetween(0, 9)));
                $comment->setArticle($this->getReference('article_' . $faker->numberBetween(0, 9)));
            }
            $manager->persist($comment);
        }
        
        // 5 RAPPER CARDS
        $i = 0;
        foreach (self::RAPPERS as $rapper => $data) {
            $rappers = new RapperCard();
            $rappers->setRapper($rapper);
            $rappers->setQuote($data['quote']);
            $rappers->setTrack($data['track']);
            $rappers->setImage($data['image']);
            $manager->persist($rappers);
            $i++;
        }

        // 21 ORACLE CARDS
        for($i = 0 ; $i < 21; $i++) {
            $oracle = new OracleCard();
            $oracle->setTitle($faker->sentence);
            $oracle->setQuote($faker->word(4));
            $oracle->setInterpretation($faker->text(100));
            $oracle->setImage('https://media1.tenor.com/images/e9c6b3759ceeb9dd1aff34a230bbd83e/tenor.gif');

            $manager->persist($oracle);
        }

        $manager->flush();
    }
}
