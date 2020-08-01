<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ContactEmail;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('home/about.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/travis", name="travis")
     */
    public function travis()
    {
        return $this->render('home/travis.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/trippin", name="trippin")
     */
    public function trippin()
    {
        return $this->render('home/trippin.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faq()
    {
        return $this->render('home/faq.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/contact", name="contact", methods={"GET","POST"})
     */
    public function contact(ContactEmail $contactEmail): Response
    {
        $contact = new Contact();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($this->getUser()){
                if(!empty($_POST['subject']) && !empty($_POST['content'])){
                    $contact->setName($this->getUser()->getName());
                    $contact->setEmail($this->getUser()->getEmail());
                    $contact->setSubject($_POST['subject']);
                    $contact->setContent($_POST['content']);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($contact);
                    $em->flush();
                    
                    $contactEmail->sendMailNewContact($contact);

                    return $this->redirectToRoute('success');
                } else {
                    $this->addFlash('error', 'All fields are required.');
                }
            } else {
                if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['subject']) && !empty($_POST['content'])) {
                    $contact->setName($_POST['name']);
                    $contact->setEmail($_POST['email']);
                    $contact->setSubject($_POST['subject']);
                    $contact->setContent($_POST['content']);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($contact);
                    $em->flush();
            
                    $contactEmail->sendMailNewContact($contact);

                    return $this->redirectToRoute('success');
                } else {
                    $this->addFlash('error', 'All fields are required.');
                }
            }
        }
        return $this->render('contact/index.html.twig', [
            'contact' => $contact
        ]);
    }

    /**
     * @Route("/sent-message", name="success")
     */
    public function contactSuccess()
    {
        return $this->render('contact/sent_message.html.twig');
    }

}
