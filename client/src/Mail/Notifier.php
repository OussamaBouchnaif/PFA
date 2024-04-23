<?php

namespace App\Mail;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class Notifier
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly string $Entreprise
    ) {

    }

    public function orderPlacedNotifier(string $destination): void
    {
        $message = (new TemplatedEmail())
            ->from($this->Entreprise)
            ->to($destination)
            ->htmlTemplate('client/mail/order_placed.html.twig')
            ->context([
                'send_email' => $destination,
            ]);

        $this->mailer->send($message);
    }
}
