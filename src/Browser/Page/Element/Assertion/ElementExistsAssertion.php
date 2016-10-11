<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Element\Assertion;

class ElementExistsAssertion extends AbstractElementAssertion
{
    /**
     * @throws \Exception
     */
    public function assert(\Closure $getElementClosure)
    {
        if (! ($element = $getElementClosure()) ) {
            throw new \Exception('Expected element to be found in the page');
        }
    }
}
