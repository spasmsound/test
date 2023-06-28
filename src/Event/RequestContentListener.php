<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

#[AsEventListener(event: RequestEvent::class)]
class RequestContentListener
{
    public function __invoke(RequestEvent $event): void
    {
        if (HttpKernelInterface::MAIN_REQUEST !== $event->getRequestType()) {
            return;
        }

        $request = $event->getRequest();

        if (null !== ($response = $this->transformRequest($request))) {
            $event->setResponse($response);
        }
    }

    protected function transformRequest(Request $request): ?JsonResponse
    {
        if ('application/json' !== $request->headers->get('Content-Type')) {
            return new JsonResponse(
                'Wrong Content-Type, only application/json is allowed',
                Response::HTTP_BAD_REQUEST
            );
        }

        /** @var string $json */
        $json = $request->getContent();
        $content = @json_decode($json, true);

        if (null === $content || 0 === count($content)) {
            return new JsonResponse('Request body is empty', Response::HTTP_BAD_REQUEST);
        }

        $request->request->set('requestData', $content);

        return null;
    }
}
