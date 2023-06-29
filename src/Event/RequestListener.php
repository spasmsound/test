<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

#[AsEventListener(event: RequestEvent::class)]
class RequestListener
{
    public function __invoke(RequestEvent $event): void
    {
        if (HttpKernelInterface::MAIN_REQUEST !== $event->getRequestType()) {
            return;
        }

        $request = $event->getRequest();

        if ('application/json' !== $request->headers->get('Content-Type')) {
            $response = new JsonResponse(
                'Wrong Content-Type, only application/json is allowed',
                Response::HTTP_BAD_REQUEST
            );

            $event->setResponse($response);
        }
    }
}
