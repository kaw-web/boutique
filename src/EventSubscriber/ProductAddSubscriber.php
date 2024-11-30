<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Product;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ProductAddSubscriber implements EventSubscriberInterface
{
    public function __construct(
        public LoggerInterface $logger
    ){

    }

    public function onKernelView(ControllerEvent $event): void
    {
        $request = $event->getRequest();
        if ($request->getMethod() === Request::METHOD_POST && str_contains($request->getPathInfo(), '/api/products')) {
            $this->logger->info('Handling POST request for Product creation');
        }

    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER=> ['onKernelView', EventPriorities::POST_WRITE]
        ];
    }
}
