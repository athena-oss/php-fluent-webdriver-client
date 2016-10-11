<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Element\Assertion;

class ElementIsDeselectedAssertion extends AbstractElementAssertion
{
    public function assert(\Closure $getElementClosure)
    {
        if (($element = $getElementClosure()) && $element->isSelected()) {
            throw new \Exception('Failed asserting that element is deselected.');
        }
    }
}
