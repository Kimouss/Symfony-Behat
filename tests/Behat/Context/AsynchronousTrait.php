<?php

namespace App\Tests\Behat\Context;

use Behat\Mink\Exception\ResponseTextException;

trait AsynchronousTrait
{
    /**
     * Based on Behat's own example.
     *
     * @see http://docs.behat.org/en/v2.5/cookbook/using_spin_functions.html#adding-a-timeout
     *
     * @param        $lambda
     * @param string $message
     * @param int    $wait
     *
     * @throws \Exception
     */
    public function spin($lambda, $message = 'Spin function timed out after %d seconds', $wait = null)
    {
        $wait = $wait ?? $this->spinDuration;

        $time = time();
        $stopTime = $time + $wait;
        while (time() < $stopTime) {
            try {
                $textSelector = $this->textSelector('Une erreur est survenue');

                if (null !== $this->getSession()->getPage()->find('xpath', "//*[$textSelector]")) {
                    throw new \Exception('Spin interrupted, error modal found on page');
                }

                if ($lambda($this)) {
                    return;
                }
            } catch (\Exception $e) {
                // do nothing
            }
            usleep(1000);
        }
        throw new \Exception(sprintf($message, $wait));
    }

    /**
     * @Then I should be redirected to :url
     *
     * @param $url
     */
    public function iShouldBeRedirectedTo($url)
    {
        $this->spin(function (FeatureContext $context) use ($url) {
            try {
                $context->assertSession()->addressEquals($this->locatePath($url));

                return true;
            } catch (ResponseTextException $e) {
                return false;
            }
        });
    }

    /**
     * @When I wait for :text to appear
     * @Then I should see :text appear
     *
     * @param $text
     */
    public function iWaitForTextToAppear($text)
    {
        $this->spin(function (FeatureContext $context) use ($text) {
            try {
                $context->assertPageContainsText($text);

                return true;
            } catch (ResponseTextException $e) {
                return false;
            }
        });
    }

    /**
     * @When I wait for :text to disappear
     * @Then I should see :text disappear
     *
     * @param $text
     *
     * @throws \Exception
     */
    public function iWaitForTextToDisappear($text)
    {
        $this->spin(function (FeatureContext $context) use ($text) {
            try {
                $context->assertPageNotContainsText($text);

                return true;
            } catch (ResponseTextException $e) {
                return false;
            }
        });
    }
}
