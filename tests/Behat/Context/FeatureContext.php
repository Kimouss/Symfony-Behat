<?php

namespace App\Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Mink\Element\DocumentElement;
use Behat\Mink\Session;
use Behat\MinkExtension\Context\MinkContext;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Routing\RouterInterface;

/**
 * Defines application features from the specific context.
 */
final class FeatureContext extends MinkContext
{
    private const SPIN_DURATION = 3;

    use AsynchronousTrait;

    protected $spinDuration;

    public function __construct(
        private Session $session,
        private RouterInterface $router,
        private KernelBrowser $client
    )
    {
        $this->spinDuration = self::SPIN_DURATION;
    }

    /**
     * @Given /^I wait "([^"]*)" seconds$/
     */
    public function iWaitSeconds($arg1): void
    {
        $this->getSession()->wait($arg1 * 1000);
    }

    /**
     * @param $text
     *
     * @return string
     */
    private function textSelector($text)
    {
        //        Replace our special char with a real nbsp   //
        $text = str_replace('[nbsp]', "\xc2\xa0", $text);

        return sprintf('contains(normalize-space(.),"%s")', $text);
    }

    private function nameSelector(DocumentElement $page, string $text)
    {
        return $page->find('xpath', "//*[@name='$text']");
    }

    private function classSelector(DocumentElement $page, string $text)
    {
        return $page->find('xpath', "//*[@class='$text']");
    }

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
