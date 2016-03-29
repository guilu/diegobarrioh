<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\EventListener;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use UserBundle\Event\UserEvents;
use UserBundle\Mailer\Mailer;

/**
 * Class DeleteUserListener
 *
 * @package UserBundle\EventListener
 */
class DeleteUserListener implements EventSubscriberInterface
{
    private $mailer;
    private $router;
    private $session;

    /**
     * @param Mailer                  $mailer
     * @param UrlGeneratorInterface   $router
     * @param SessionInterface        $session
     */
    public function __construct(
        Mailer $mailer,
        UrlGeneratorInterface $router,
        SessionInterface $session
    ) {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->session = $session;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            UserEvents::USER_DELETE_COMPLETED => 'onUserDeleteSuccess',
        );
    }

    /**
     * @param FilterUserResponseEvent $event
     */
    public function onUserDeleteSuccess(FilterUserResponseEvent $event)
    {
        $user = $event->getUser();
        $this->mailer->sendConfirmationDeletionEmailMessage($user);

        $this->session->set('fos_user_send_confirmation_email/email', $user->getEmail());

        //$url = $this->router->generate('fos_user_registration_check_email');

        //$event->setResponse(new RedirectResponse($url));
    }
}
