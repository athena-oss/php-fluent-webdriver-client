<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;

class ElementValueIsNotEqualToAssertion extends AbstractElementAssertion
{
    /** @var string */
    private $expectedString;

    /**
     * @param string $expectedString
     * @param ElementFinderInterface $elementFinder
     */
    public function __construct($expectedString, ElementFinderInterface $elementFinder)
    {
        $this->expectedString = $expectedString;

        parent::__construct($elementFinder);
    }

    /**
     * @throws \UnexpectedValueException
     */
    public function assert(\Closure $getElementClosure)
    {
        if (($element = $getElementClosure()) && $this->expectedString === $element->getAttribute('value')) {
            throw new \UnexpectedValueException(
                sprintf(
                    "Expected element value not to equal '%s' [actual value is '%s']",
                    $element->getAttribute('value'),
                    $this->expectedString
                )
            );
        }
    }
}
