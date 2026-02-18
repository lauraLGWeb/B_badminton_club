<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class LocaleListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        
        // Récupère la locale depuis la session si elle existe
        if ($locale = $request->getSession()->get('_locale')) {
            $request->setLocale($locale);
        }
    }
}