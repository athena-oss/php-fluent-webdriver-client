<?php
namespace OLX\FluentWebDriverClient\Browser\Page\Find\Wait;

use OLX\FluentWebDriverClient\Exception\NoSuchElementException;

class WaitUntilPresence extends AbstractWait
{
    protected function validate($targetClosure, $locator = null)
    {
        if (sizeof($targetClosure()) === 0) {
            throw new NoSuchElementException(
                sprintf('Timeout waiting for the element to exist after %d seconds', $this->timeOutInSeconds)
            );
        }
        return true;
    }
}

