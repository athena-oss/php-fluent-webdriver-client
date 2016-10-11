<?php
namespace OLX\FluentWebDriverClient\Browser\Page\Find\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\TargetDecoratorInterface;
use OLX\FluentWebDriverClient\Exception\UnexpectedValueException;

class ElementTextEqualsAssertion implements TargetDecoratorInterface
{
    private $expectedText;

    /**
     * TextEqualsAssertion constructor.
     * @param $compareToText
     */
    public function __construct($compareToText)
    {
        $this->expectedText = $compareToText;
    }

    public function decorate($targetClosure, $locator)
    {
        $text = $targetClosure()->getText();
        if ($text != $this->expectedText) {
            throw new UnexpectedValueException(
                sprintf("Element's text is different than expected. Found '%s' instead of '%s'", $text, $this->expectedText)
            );
        }
        return true;
    }
}

