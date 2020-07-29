<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class ContactEmail
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMailNewContact($contact)
    {
        $newEmail = new TemplatedEmail();
        $newEmail
            ->from('d5723b0139-e2ef70@inbox.mailtrap.io')
            ->to('anais.mailtest@gmail.com')
            ->subject('New Message from W.')
            ->htmlTemplate('contact/email/new_contact.html.twig')
            ->context([
                'contact' => $contact
            ]);
        $this->mailer->send($newEmail);
    }
}