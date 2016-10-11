<?php
namespace OLX\FluentWebDriverClient\Browser\Page\Find\Wait;

use OLX\FluentWebDriverClient\Exception\ElementNotVisibleException;
use Facebook\WebDriver\WebDriverExpectedCondition;

class WaitUntilVisibility extends AbstractWait
{
    /**
     * @codeCoverageIgnore
     */
    protected function validate($targetClosure, $locator = null)
    {
        try {
            WebDriverExpectedCondition::visibilityOf($targetClosure());
            return true;
        } catch (\Exception $e) {
            throw new ElementNotVisibleException(
                sprintf('Timeout waiting for the element to be visible after %d seconds', $this->timeOutInSeconds)
            );
        }
    }
}

