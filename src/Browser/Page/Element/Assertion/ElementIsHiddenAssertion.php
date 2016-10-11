<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Exception\ElementIsVisibleException;

class ElementIsHiddenAssertion extends AbstractElementAssertion
{
    public function assert(\Closure $getElementClosure)
    {
        if (($element = $getElementClosure()) && $element->isDisplayed()) {
            throw new ElementIsVisibleException('Failed asserting that element is hidden.');
        }
    }
}
