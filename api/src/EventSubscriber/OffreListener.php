<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use App\Entity\Offre;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;


final class OffreListener implements EventSubscriberInterface
{
    private $tokenStorage;

    /**
     * OffreListener constructor.
     *
     * @param TokenStorageInterface $passwordEncoder
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Subscribes to prePersist and preUpdate Events.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['defineOwner', EventPriorities::PRE_WRITE],
        ];
    }

    public function defineOwner(ViewEvent $event){
        $user = $this->tokenStorage->getToken()->getUser();
        $offre = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$offre instanceof Offre || Request::METHOD_POST !== $method) {
            return;
        }
        $offre->setOwner($user);
    }
}