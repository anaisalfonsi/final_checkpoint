<?php 

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ArticleRepository;
use App\Entity\Article;
use App\Entity\User;

class AdminEmailService {

    private $em;

    public function __construct(MailerInterface $mailer, EntityManagerInterface $em)
    {
        $this->mailer = $mailer;
        $this->em = $em;
    }

    public function sendEmailNewArticle($articleId)
    {
        $article = $this->em->getRepository(Article::class)->findOneBy(['id' => $articleId]);
        
        if ($article) {
            $users = $this->em->getRepository(User::class)->findAll();
            $userAddresses = [];
                foreach ($users as $user) {
                    $userMail = $user->getEmail();
                    $userAddresses[] = $userMail;
                }
                    $newEmail = new TemplatedEmail();
                    $newEmail
                        ->from('d5723b0139-e2ef70@inbox.mailtrap.io')
                        ->to($userMail)
                        ->subject('A new Article is Out!')
                        ->htmlTemplate('user/email/new_article_email.html.twig')
                        ->context([
                            'user' => $user,
                            'article' => $article
                        ]);
            $this->mailer->send($newEmail);
        }
    }
}