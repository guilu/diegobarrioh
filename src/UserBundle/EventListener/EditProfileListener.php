<?php
/**
 * Created by PhpStorm.
 * User: diegobarrioh
 * Date: 18/11/13
 * Time: 12:38
 */

namespace UserBundle\EventListener;


use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Listener responsible to change the redirection at the end of the password resetting
 * @package UserBundle\EventListener
 */
class EditProfileListener implements EventSubscriberInterface
{
    private $router;

    /**
     * @param UrlGeneratorInterface $router
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::PROFILE_EDIT_SUCCESS => 'onEditProfileSuccess',
        );
    }

    /**
     * @param FormEvent $event
     */
    public function onEditProfileSuccess(FormEvent $event)
    {
        //aqui hacemos lo que sea cuando la edición ha sido success
    }
}
