<?php
/**
 * Created by PhpStorm.
 * User: diegobarrioh
 * Date: 14/9/15
 * Time: 14:29
 */

namespace UserBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use UserBundle\Event\UserEvents;

/**
 * Class DeleteUserController
 *
 * @package UserBundle\Controller
 */
class DeleteUserController extends Controller
{
    /**
     * Borra un usuario y lo desloguea....
     *
     * @param Request $request
     *
     * @throws AccessDeniedException
     *
     * @return RedirectResponse
     *
     * @Route("/profile/delete", name="fos_user_delete")
     */
    public function deleteAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        //$userManager->deleteUser($user);

        $url = $this->generateUrl('fos_user_security_logout');
        $response = new RedirectResponse($url);

        $dispatcher->dispatch(
            UserEvents::USER_DELETE_COMPLETED,
            new FilterUserResponseEvent($user, $request, $response)
        );

        $this->addFlash("info", "Tu cuenta se ha eliminado correctamente");

        return $response;
    }
}
