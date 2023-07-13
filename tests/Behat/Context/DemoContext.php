<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Mink\Session;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Routing\RouterInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class DemoContext implements Context
{
    public function __construct(
        private Session $session,
        private RouterInterface $router,
        private KernelBrowser $client
    )
    {
    }

    /**
     * @Then I visit some page
     */
    public function visitSomePage(): void
    {
        $this->session->visit($this->router->generate('some_route'));
    }

    /**
     * @Then the response should be received
     */
    public function theResponseShouldBeReceived(): void
    {
        assert($this->client->getResponse()->getStatusCode() === 200);
    }

    /**
     * @Then I should see the text :text
     */
    public function iShouldSeeTheText($text)
    {
        if (!str_contains($this->response->text(), $text)) {
            throw new \RuntimeException("Cannot find expected text '$text'");
        }
    }

    /**
     * @When I click on :link
     */
    public function iClickOn($link)
    {
        $this->response = $this->client->clickLink($link);
    }
}
