<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Element\Assertion;

class ElementDoesNotExistAssertion extends AbstractElementAssertion
{
    /**
     * @throws \Exception
     */
    public function assert(\Closure $getElementClosure)
    {
        if (($element = $getElementClosure()) && sizeof($element) > 0) {
            throw new \Exception('Expected element not to be found in the page [it was found %d time(s)]', sizeof($element));
        }
    }
}
