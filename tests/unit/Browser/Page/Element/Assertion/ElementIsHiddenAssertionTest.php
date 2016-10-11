<?php

namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementIsHiddenAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;
use OLX\FluentWebDriverClient\Tests\Helpers\ElementAssertionHelperTrait;

class ElementIsHiddenAssertionTest extends \PHPUnit_Framework_TestCase
{
    use ElementAssertionHelperTrait;

    protected function runAssertion($element)
    {
        $mockElementFinder = \Phake::mock(ElementFinderInterface::class);
        $assertion = (new ElementIsHiddenAssertion($mockElementFinder));
        $assertion->assert(function() use ($element) {
            return $element;
        });
    }

    public function testAssertion_HiddenElement_ShouldSucceed()
    {
        \Phake::when($this->mockElement)->isDisplayed()->thenReturn(false);

        $this->runAssertion($this->mockElement);

        \Phake::verify($this->mockElement, \Phake::times(1))->isDisplayed();
    }

    /**
     * @expectedException \OLX\FluentWebDriverClient\Exception\ElementIsVisibleException
     */
    public function testAssertion_VisibleElement_ShouldFail()
    {
        \Phake::when($this->mockElement)->isDisplayed()->thenReturn(true);

        $this->runAssertion($this->mockElement);

        \Phake::verify($this->mockElement, \Phake::times(1))->isDisplayed();
    }
}
