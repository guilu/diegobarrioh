<?php

namespace AppBundle\Features\Context;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Mink\Driver\BrowserKitDriver;
use Behat\Mink\Exception\ExpectationException;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\SwiftmailerBundle\DataCollector\MessageDataCollector;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Defines application features from the specific context.
 */
class WebContext extends BaseContext
{

    /**
     * @Given /^I am authenticated as "([^"]*)"$/
     *
     * @param string $username
     *
     * @throws UnsupportedDriverActionException
     */
    public function iAmAuthenticatedAs($username)
    {
        $driver = $this->getSession()->getDriver();
        if (!$driver instanceof BrowserKitDriver) {
            throw new UnsupportedDriverActionException('This step is only supported by the BrowserKitDriver', $driver);
        }

        $providerKey = 'secured_area';
        $token       = new UsernamePasswordToken($username, null, $providerKey, array('ROLE_ADMIN'));
        $this->getContainer()->get('security.token_storage')->setToken($token);
        $this->getSession()->setCookie('_security_secured_area', serialize($token));
    }

    /**
     * @Given /^I should have a "([^"]*)" role$/
     * @param string $role
     */
    public function iShouldHaveARole($role)
    {
        /** @var UserInterface $user */
        $user = $this->getContainer()->get('security.token_storage')->getToken();
        in_array($role, $user->getRoles());
    }

    /**
     * @Given /^I should get an email on "(?P<email>[^"]+)" with:$/
     *
     * @param string       $email
     * @param PyStringNode $text
     *
     * @return mixed
     * @throws ExpectationException
     * @throws UnsupportedDriverActionException
     *
     */
    public function iShouldGetAnEmail($email, PyStringNode $text)
    {
        $error     = sprintf('No message sent to "%s"', $email);
        /** @var Profile $profile */
        $profile   = $this->getSymfonyProfile();
        /** @var MessageDataCollector $collector */
        $collector = $profile->getCollector('swiftmailer');
        foreach ($collector->getMessages() as $message) {
            // Checking the recipient email and the X-Swift-To header to handle the RedirectingPlugin.
            // If the recipient is not the expected one, check the next mail.
            /** @var \Swift_Message $message */
            $correctRecipient = array_key_exists($email, $message->getTo());

            $headers = $message->getHeaders();
            $correctXToHeader = false;
            if ($headers->has('X-Swift-To')) {
                $correctXToHeader = array_key_exists($email, $headers->get('X-Swift-To')->getFieldBodyModel());
            }

            if (!$correctRecipient && !$correctXToHeader) {
                continue;
            }

            try {
                // checking the content
                return \PHPUnit_Framework_Assert::assertContains($text->getRaw(), $message->getBody());
            } catch (AssertException $e) {
                $error = sprintf(
                    'An email has been found for "%s" but without the text "%s".',
                    $email,
                    $text->getRaw()
                );
            }
        }

        throw new ExpectationException($error, $this->getSession());
    }

    /**
     * @Given /^I have a session$/
     */
    public function iHaveASession()
    {
        \PHPUnit_Framework_Assert::assertInstanceOf('Behat\\Mink\\Session', $this->getSession());
    }

    /**
     * @Given /^I have a kernel instance$/
     */
    public function iHaveAKernelInstance()
    {
        \PHPUnit_Framework_Assert::assertInstanceOf(
            'Symfony\\Component\\HttpKernel\\KernelInterface',
            $this->getKernel()
        );
    }

    /**
     * @Then /^After the modal "([^"]*)" opens$/
     *
     * @param string $title El titulo del modal
     */
    public function afterTheModalOpens($title)
    {
        $this->jqueryWaitUntilVisible(10000, "myModal");
        $this->assertElementContainsText('h4.modal-title', $title);
        \PHPUnit_Framework_Assert::AssertTrue($this->getSession()->getPage()->find('css', '#myModal')->isVisible());
    }

}
