<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;

class RedirectToLoginListener
{
    private $router;
    private $security;

    public function __construct(RouterInterface $router, Security $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $route = $event->getRequest()->attributes->get('_route');

        if (!$this->security->getUser() && $route !== 'app_login' && $route != 'contact') {
            $event->setResponse(new RedirectResponse($this->router->generate('app_login')));
        }
    }
}
