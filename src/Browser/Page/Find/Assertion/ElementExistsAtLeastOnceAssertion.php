<?php
namespace OLX\FluentWebDriverClient\Browser\Page\Find\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\TargetDecoratorInterface;
use OLX\FluentWebDriverClient\Exception\NoSuchElementException;

class ElementExistsAtLeastOnceAssertion implements TargetDecoratorInterface
{
    public function decorate($targetClosure, $locator)
    {
        $count = sizeof($targetClosure());
        if ($count === 0) {
            throw new NoSuchElementException("Expected element was not found on the page at least once");
        }
        return true;
    }
}

