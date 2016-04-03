<?php
/**
 * Created by PhpStorm.
 * User: diegobarrioh
 * Date: 11/9/15
 * Time: 11:17
 */

namespace AppBundle\Features\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Behat\Symfony2Extension\Driver\KernelDriver;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class BaseContext
 * Conexto Básico de Behat con Mink, aqui tengo los métodos protected que van a poder utilizar los demás contextos
 *
 * @package AppBundle\Features\Context
 */
class BaseContext extends MinkContext implements Context, SnippetAcceptingContext, KernelAwareContext
{
    use KernelDictionary;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->setKernel($kernel);
    }

    /**
     * @return mixed
     * @throws UnsupportedDriverActionException
     */
    public function getSymfonyProfile()
    {
        /** @var KernelDriver $driver */
        $driver = $this->getSession()->getDriver();
        if (!$driver instanceof KernelDriver) {
            throw new UnsupportedDriverActionException(
                'You need to tag the scenario with "@mink:symfony2". Using the profiler is not supported by %s',
                $driver
            );
        }
        /** @var Client $client */
        $client = $driver->getClient();
        $profile = $client->getProfile();
        if (false === $profile) {
            throw new \RuntimeException(
                'The profiler is disabled.'.
                'Activate it by setting framework.profiler.only_exceptions to false in your config'
            );
        }

        return $profile;
    }


    /**
     * Espera $duration milisegundos
     * @param int $duration
     */
    protected function jqueryWait($duration = 1000)
    {
        $this->getSession()->wait($duration, false);
    }

    /**
     * Waits until an element is visible or duration
     * @param $duration
     * @param $id
     */
    protected function jqueryWaitUntilVisible($duration, $id)
    {
        $this->getSession()->wait($duration, '$(\'#'.$id.'\').css(\'display\') == \'block\'');
    }

    /**
     * Metodo que hace a jquery esperar $duration miliseguntos o hasta que terminen
     * @param int $duration
     */
    protected function jqueryWaitForAnimationToEnd($duration = 1000)
    {
        $this->getSession()->wait($duration, 'jQuery(\':animated\').length');
    }
}
