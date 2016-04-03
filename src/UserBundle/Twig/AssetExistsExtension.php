<?php
namespace UserBundle\Twig;

use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class AssetExistsExtension
 *
 * @package UserBundle\Twig
 */
class AssetExistsExtension extends \Twig_Extension
{

    private $kernel;

    /**
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('asset_exists', array($this, 'assetExists')),
        );
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public function assetExists($path)
    {

        $webRoot = realpath($this->kernel->getRootDir() . '/../web/');

        $toCheck = $webRoot ."/". $path ;

        // check if the file exists
        if (!is_file($toCheck)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'asset_exists';
    }

}