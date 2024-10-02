<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        // Récupérer l'exception lancée
        $exception = $event->getThrowable();

        // Créer une réponse JSON avec le message d'erreur
        $response = new JsonResponse([
            'error' => $exception->getMessage(),
        ]);

        // Si c'est une HttpException, utilisez le code d'état
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
        } else {
            $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Envoyer la réponse JSON
        $event->setResponse($response);
    }
}
