<?php

declare(strict_types=1);

namespace App\Domain\Common\Subscribers\Subscribers;

use App\Domain\Contact\Events\ContactMailEvent;
use App\Domain\Order\Mails\Events\ConfirmMailEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Bridge\Sendgrid\Transport\SendgridSmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MailsSubscriber implements EventSubscriberInterface
{
    /** @var string */
    private $dsn;

    /** @var Environment */
    private $templating;

    public function __construct(
        string $dsn,
        Environment $templating
    ) {
        $this->dsn = $dsn;
        $this->templating = $templating;
    }

    public static function getSubscribedEvents()
    {
        return [
            ConfirmMailEvent::class => 'confirmOrder',
            ContactMailEvent::class => 'onContact',
        ];
    }

    public function confirmOrder(ConfirmMailEvent $event)
    {
        $customer = $event->getOrder()->getCustomer();
        $order = $event->getOrder();
        $delivery = $event->getOrder()->getDelivery();
        $email = (new Email())
            ->from(new Address('commande@monpremiersommelier.com', 'Mon Premier Sommelier'))
            ->to(
                new Address(
                    $customer->getEmail(),
                    sprintf('%s %s', $customer->getFirstname(), $customer->getLastname())
                )
            )
            ->subject('Mon Premier Sommelier - Confirmation de commande')
            ->embedFromPath(__DIR__.'/../../../../../public/img/logo.png', 'logo')
            ->embedFromPath(__DIR__.'/../../../../../public/img/package.png', 'package')
            ->html(
                $this->templating->render(
                    'emails/confirm_order.html.twig',
                    [
                        'order' => $order,
                        'delivery' => $delivery,
                        'customer' => $customer
                    ]
                )
            );

        $this->getMailer()->send($email);
        //TODO Envoi mail Mon Premier Sommelier pour informer de la commande.
        $email = (new Email())
            ->from(
                new Address(
                    $customer->getEmail(),
                    sprintf('%s %s', $customer->getFirstname(), $customer->getLastname())
                )
            )
            ->to(new Address('morvan.aurelien@gmail.com', 'Mon Premier Sommelier'))
            ->subject('Mon Premier Sommelier - Nouvelle commande')
            ->embedFromPath(__DIR__.'/../../../../../public/img/logo.png', 'logo')
            ->embedFromPath(__DIR__.'/../../../../../public/img/package.png', 'package')
            ->html(
                $this->templating->render(
                    'emails/new_order.html.twig',
                    [
                        'order' => $order,
                        'delivery' => $delivery,
                        'customer' => $customer
                    ]
                )
            );

        $this->getMailer()->send($email);
    }

    public function onContact(ContactMailEvent $event)
    {
        $contact = $event->getContact();
        $email = (new Email())
            ->from(new Address($contact->getEmail(), $contact->getName()))
            ->to(new Address('contact@monpremiersommelier.com', 'Mon Premier Sommelier'))
            ->subject('Mon Premier Sommelier - Demande d\'informations')
            ->embedFromPath(__DIR__.'/../../../../../public/img/logo.png', 'logo')
            ->html($this->templating->render('emails/contact.html.twig'));

        $this->getMailer()->send($email);
    }

    private function getMailer(): Mailer
    {
        static $mailer;

        if (is_null($mailer)) {
            $mailer = new Mailer(Transport::fromDsn($this->dsn));
        }

        return $mailer;
    }
}
