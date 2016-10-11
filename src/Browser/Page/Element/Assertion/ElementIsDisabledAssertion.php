<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Element\Assertion;

class ElementIsDisabledAssertion extends AbstractElementAssertion
{
    public function assert(\Closure $getElementClosure)
    {
        if (($element = $getElementClosure()) && $element->isEnabled()) {
            throw new \Exception('Failed asserting that element is disabled.');
        }
    }
}
