<?php
namespace App\Notification;

use Twig\Environment;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\Form\Form;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;


class ContactNotification {
    /**
     * @var MailerInterface $mailer
     * @var Environment $renderer
     */

    private $mailer;
    private $renderer;

    public function __construct(MailerInterface $mailer, Environment $renderer){

        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact){
        
        // $form = $this->createForm(ContactType::class, $contact);
        // $form -> handleRequest($contact);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $data = $form->getData();

        $message=(new TemplatedEmail())
            ->from('noreply@agence.fr')
            ->subject('Nouveau message du formulaire de contact')
            ->to('contact@agence.fr')
            ->replyTo($contact->getEmail())
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'contact' => $contact,
            ]);

        $this->mailer->send($message);
        }

}