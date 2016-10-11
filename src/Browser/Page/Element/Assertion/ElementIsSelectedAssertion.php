<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Exception\ElementNotSelectedException;

class ElementIsSelectedAssertion extends AbstractElementAssertion
{
    public function assert(\Closure $getElementClosure)
    {
        if (($element = $getElementClosure()) && !$element->isSelected()) {
            throw new ElementNotSelectedException('Failed asserting that element is selected.');
        }
    }
}
