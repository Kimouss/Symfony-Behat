<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class DemoContext implements Context
{
    public function __construct(
        private KernelBrowser $client
    )
    {}

    /**
     * @Given I navigate to :path
     * @When a demo scenario sends a request to :path
     */
    public function aDemoScenarioSendsARequestTo(string $path): void
    {
        // Notice that response is now an instance
        // of \Symfony\Component\DomCrawler\Crawler
        $this->response = $this->client->request('GET', $path);
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
