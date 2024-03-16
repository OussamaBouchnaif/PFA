<?php

namespace App\Service\Api\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ObjectNotFoundException extends NotFoundHttpException
{
    public function __construct(string $message = 'Objet non trouvé', \Throwable $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct($message, $previous, $code, $headers);
    }
}