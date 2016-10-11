<?php

namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementTextIsNotEqualToAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;
use OLX\FluentWebDriverClient\Tests\Helpers\ElementAssertionHelperTrait;

class ElementTextIsNotEqualToTest extends \PHPUnit_Framework_TestCase
{
    use ElementAssertionHelperTrait;

    protected function runAssertion($expectedText, $element)
    {
        $mockElementFinder = \Phake::mock(ElementFinderInterface::class);
        $assertion = (new ElementTextIsNotEqualToAssertion($expectedText, $mockElementFinder));
        $assertion->assert(function() use ($element) {
            return $element;
        });
    }

    /**
     * @after
     */
    public function verify()
    {
        \Phake::verify($this->mockElement, \Phake::atLeast(1))->getText();
    }

    public function testAssertion_GivenTextDoesNotMatchElementText_ShouldSucceed()
    {
        \Phake::when($this->mockElement)->getText()->thenReturn('foo');
        $this->runAssertion('bar', $this->mockElement);
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testAssertion_GivenTextMatchesElementText_ShouldFail()
    {
        \Phake::when($this->mockElement)->getText()->thenReturn('foo');
        $this->runAssertion('foo', $this->mockElement);
    }
}
