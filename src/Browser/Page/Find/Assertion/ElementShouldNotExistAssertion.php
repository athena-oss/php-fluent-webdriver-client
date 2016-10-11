<?php
namespace OLX\FluentWebDriverClient\Browser\Page\Find\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\TargetDecoratorInterface;
use OLX\FluentWebDriverClient\Exception\ElementNotExpectedException;
use OLX\FluentWebDriverClient\Exception\StopChainException;
use Facebook\WebDriver\Exception\NoSuchElementException;

class ElementShouldNotExistAssertion implements TargetDecoratorInterface
{
    public function decorate($targetClosure, $locator)
    {
        try {
            if (($count = sizeof($targetClosure())) > 0) {
                throw new ElementNotExpectedException(
                    sprintf("Expected element should not exist on the page and was found '%d' time(s)", $count)
                );
            }
        } catch (NoSuchElementException $e) {
            throw new StopChainException();
        }
    } // @codeCoverageIgnore
}
