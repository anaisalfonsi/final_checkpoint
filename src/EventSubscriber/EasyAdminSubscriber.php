<?php

namespace App\EventSubscriber;

use App\Entity\Article;
use App\Service\AdminEmailService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class EasyAdminSubscriber implements EventSubscriberInterface 
{
    private $adminEmailService;
    private $em;

    public function __construct(AdminEmailService $adminEmailService, EntityManagerInterface $em)
    {
        $this->em = $em; 
        $this->adminEmailService = $adminEmailService;
    }

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::POST_PERSIST => 'onPostPersist'
        ];
    }

    public function onPostPersist(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if($entity instanceof Article)
        {
            $articleId = $entity->getId();
            $this->adminEmailService->sendEmailNewArticle($articleId);
        }
    }
}