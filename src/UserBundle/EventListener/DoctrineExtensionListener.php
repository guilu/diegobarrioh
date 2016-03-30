<?php
/**
 * Created by PhpStorm.
 * User: diegobarrioh
 * Date: 07/11/14
 * Time: 08:37
 */

namespace UserBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class DoctrineExtensionListener
 *
 * @package UserBundle\EventListener
 */
class DoctrineExtensionListener implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function onLateKernelRequest(GetResponseEvent $event)
    {
        $translatable = $this->container->get('gedmo.listener.translatable');
        $translatable->setTranslatableLocale($event->getRequest()->getLocale());
    }

    /**
     * {@inheritdoc}
     */
    public function onKernelRequest()
    {

        $tokenStorage = $this->container->get('security.token_storage');
        $authorizationChecker = $this->container->get(
            'security.authorization_checker',
            ContainerInterface::NULL_ON_INVALID_REFERENCE
        );
        if (null !== $tokenStorage &&
            null !== $tokenStorage->getToken() &&
            $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')
        ) {
            $loggable = $this->container->get('gedmo.listener.loggable');
            $loggable->setUsername($tokenStorage->getToken()->getUsername());
        }
    }
}
