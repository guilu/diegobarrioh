<?php

namespace UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class UserBundle
 *
 * @package UserBundle
 */
class UserBundle extends Bundle
{

    /**
     * Sobreescritura del método getParent para acceder a FOSUserBundle
     * @return string
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
