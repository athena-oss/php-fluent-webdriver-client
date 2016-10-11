<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Exception\ElementIsHiddenException;

class ElementIsDisplayedAssertion extends AbstractElementAssertion
{
    public function assert(\Closure $getElementClosure)
    {
        if (($element = $getElementClosure()) && !$element->isDisplayed()) {
            throw new ElementIsHiddenException('Failed asserting that element is displayed.');
        }
    }
}
