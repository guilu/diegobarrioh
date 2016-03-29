<?php
/**
 * Created by PhpStorm.
 * User: diegobarrioh
 * Date: 24/02/14
 * Time: 09:36
 */

namespace UserBundle\EventListener;

use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class LoginListener
 *
 * @package UserBundle\EventListener
 */
class LoginListener
{
    /**
     * @var string
     */
    protected $locale;

    /**
     * Router
     *
     * @var Router
     */
    protected $router;

    /**
     * @var SecurityContext
     */
    protected $securityContext;


    /**
     * @param SecurityContext $securityContext
     * @param Router          $router
     */
    public function __construct(SecurityContext $securityContext, Router $router)
    {
        $this->securityContext = $securityContext;
        $this->router = $router;
    }

    /**
     * @param AuthenticationEvent $event
     */
    public function handle(AuthenticationEvent $event)
    {
        $token = $event->getAuthenticationToken();
        $this->locale = $token->getUser()->getIdioma();

    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {

        if (null !== $this->locale) {
            $request = $event->getRequest();
            $request->setLocale($this->locale);
        }
    }
}
