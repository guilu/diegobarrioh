<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DefaultControllerTest
 *
 * @package AppBundle\Tests\Controller
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * Prueba el index
     */
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome!', $crawler->filter('#welcome h1')->text());
    }
}