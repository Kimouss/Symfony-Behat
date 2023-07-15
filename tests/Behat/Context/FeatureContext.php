<?php

namespace App\Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Hook\AfterStep;
use Behat\Mink\Element\DocumentElement;
use Behat\Mink\Session;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Routing\RouterInterface;

/**
 * Defines application features from the specific context.
 */
final class FeatureContext extends MinkContext implements Context
{
    private const SPIN_DURATION = 3; // 1 = 1000ms = 1sec
    private const TIME_TO_RECORDING = 0; // 1 = 100ms = 0.1sec

    use AsynchronousTrait;

    protected int $spinDuration;

    public function __construct(
        private Session $session,
        private RouterInterface $router,
        private KernelBrowser $client,
    )
    {
        $this->spinDuration = self::SPIN_DURATION;
    }

    #[AfterStep]
    public function waitForRecording(): void
    {
        $this->getSession()->wait(self::TIME_TO_RECORDING * 100);
    }

    #[Given('I wait :int seconds')]
    public function iWaitSeconds($int): void
    {
        $this->getSession()->wait($int * 1000);
    }

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

    #[Then('the response should be received')]
    public function theResponseShouldBeReceived(): void
    {
        assert($this->client->getResponse()->getStatusCode() === 200);
    }

    #[When('I click on link :wording')]
    public function iClickOnLink($wording): void
    {
        $page = $this->getSession()->getPage();
        $textSelector = $this->textSelector($wording);
        $link = $page->find('xpath', "//a[$textSelector]");

        if (!$link) {
            throw new \ErrorException("Page does not contain $wording", $this->getSession()->getDriver());
        }

        $link->click();
    }
}
