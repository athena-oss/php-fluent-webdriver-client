<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Exception\ElementNotEnabledException;

class ElementIsEnabledAssertion extends AbstractElementAssertion
{
    public function assert(\Closure $getElementClosure)
    {
        if (($element = $getElementClosure()) && !$element->isEnabled()) {
            throw new ElementNotEnabledException('Failed asserting that element is enabled.');
        }
    }
}
