<?php

namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementTextEqualsToAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;
use OLX\FluentWebDriverClient\Tests\Helpers\ElementAssertionHelperTrait;

class ElementTextEqualsToAssertionTest extends \PHPUnit_Framework_TestCase
{
    use ElementAssertionHelperTrait;

    protected function runAssertion($expectedText, $element)
    {
        $mockElementFinder = \Phake::mock(ElementFinderInterface::class);
        $assertion = (new ElementTextEqualsToAssertion($expectedText, $mockElementFinder));
        $assertion->assert(function() use ($element) {
            return $element;
        });
    }

    public function testAssertion_GivenTextMatchesElementText_ShouldSucceed()
    {
        \Phake::when($this->mockElement)->getText()->thenReturn('foo');

        $this->runAssertion('foo', $this->mockElement);

        \Phake::verify($this->mockElement, \Phake::times(1))->getText();
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testAssertion_GivenTextDoesNotMatchElementText_ShouldFail()
    {
        \Phake::when($this->mockElement)->getText()->thenReturn('bar');

        $this->runAssertion('foo', $this->mockElement);

        \Phake::verify($this->mockElement, \Phake::times(1))->getText();
    }
}
