<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Find\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\TargetDecoratorInterface;

class ElementExistsOnlyOnceAssertion implements TargetDecoratorInterface
{
    public function decorate($targetClosure, $locator)
    {
        if (1 != ($totalMatches = sizeof($targetClosure()))) {
            throw new \Exception(sprintf("Expected 1 element, found %d", $totalMatches));
        }
    }
}
