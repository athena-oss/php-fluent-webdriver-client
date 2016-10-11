<?php
namespace OLX\FluentWebDriverClient\Browser\Page\Find\Wait;

use Facebook\WebDriver\WebDriverExpectedCondition;

class WaitUntilClickable extends AbstractWait
{
    /**
     * @codeCoverageIgnore
     */
    protected function validate($targetClosure, $locator = null)
    {
        try {
            WebDriverExpectedCondition::elementToBeClickable($locator);
            return true;
        } catch (\Exception $e) {
            throw new \Exception(
                sprintf('Timeout waiting for the element to be clickable after %d seconds', $this->timeOutInSeconds)
            );
        }
    }
}

