<?php

namespace App\Domain\Common\Subscribers\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RequestSubscriber implements EventSubscriberInterface
{
    /** @var bool */
    protected $siteOnline;

    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    public function __construct(bool $siteOnline, UrlGeneratorInterface $urlGenerator)
    {
        $this->siteOnline = $siteOnline;
        $this->urlGenerator = $urlGenerator;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onRequest',
        ];
    }

    public function onRequest(RequestEvent $event)
    {
        $route = $event->getRequest()->attributes->get('_route');
        if (!$this->siteOnline && !in_array($route, ['coming-soon', 'easyadmin', 'security_login'])) {
            $event->setResponse(new RedirectResponse($this->urlGenerator->generate('coming-soon')));
        }
    }
}
