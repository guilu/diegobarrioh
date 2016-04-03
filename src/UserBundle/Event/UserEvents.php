<?php
/**
 * Created by PhpStorm.
 * User: diegobarrioh
 * Date: 15/9/15
 * Time: 7:55
 */

namespace UserBundle\Event;

/**
 * Class UserEvents
 *
 * @package UserBundle\Event
 */
final class UserEvents
{
    /**
     * The USER_DELETE_COMPLETED event occurs after deleting the user.
     *
     * This event allows you to access the response which will be sent.
     * The event listener method receives a FOS\UserBundle\Event\FilterUserResponseEvent instance.
     */
    const USER_DELETE_COMPLETED = 'fos_user.user.delete.completed';
}
