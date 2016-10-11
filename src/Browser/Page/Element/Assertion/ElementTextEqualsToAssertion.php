<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;

class ElementTextEqualsToAssertion extends AbstractElementAssertion
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
        if (($element = $getElementClosure()) && $this->expectedString != $element->getText()) {
            throw new \UnexpectedValueException(
                sprintf(
                    "Expected element innerHTML to equal '%s' [actual innerHTML is '%s']",
                    $element->getText(),
                    $this->expectedString
                )
            );
        }
    }
}
