<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Environment;

class ExceptionListener
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof NotFoundHttpException) {
            // Customize your response object to display the exception details
            $response = new Response(
                $this->twig->render('client/exceptions/404.html.twig', ['exception' => $exception])
            );

            // Http code for not found
            $response->setStatusCode(Response::HTTP_NOT_FOUND);

            // Send the modified response object to the event
            $event->setResponse($response);
        }
    }

}
