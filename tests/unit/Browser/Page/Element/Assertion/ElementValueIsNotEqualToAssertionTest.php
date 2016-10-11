<?php

namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementValueIsNotEqualToAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;
use OLX\FluentWebDriverClient\Tests\Helpers\ElementAssertionHelperTrait;

class ElementValueIsNotEqualToAssertionTest extends \PHPUnit_Framework_TestCase
{
    use ElementAssertionHelperTrait;

    protected function runAssertion($expectedText, $element)
    {
        $mockElementFinder = \Phake::mock(ElementFinderInterface::class);
        $assertion = (new ElementValueIsNotEqualToAssertion($expectedText, $mockElementFinder));
        $assertion->assert(function() use ($element) {
            return $element;
        });
    }

    /**
     * @after
     */
    public function verify()
    {
        \Phake::verify($this->mockElement, \Phake::atLeast(1))->getAttribute('value');
    }

    public function testAssertion_GivenValueDoesNotMatchElementValue_ShouldSucceed()
    {
        \Phake::when($this->mockElement)->getAttribute('value')->thenReturn('foo');
        $this->runAssertion('bar', $this->mockElement);
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testAssertion_GivenValueMatchesElementValue_ShouldFail()
    {
        \Phake::when($this->mockElement)->getAttribute('value')->thenReturn('foo');
        $this->runAssertion('foo', $this->mockElement);
    }
}
