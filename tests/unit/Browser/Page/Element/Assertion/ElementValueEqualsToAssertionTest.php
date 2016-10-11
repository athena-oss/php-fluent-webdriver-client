<?php

namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementValueEqualsToAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;
use OLX\FluentWebDriverClient\Tests\Helpers\ElementAssertionHelperTrait;

class ElementValueEqualsToAssertionTest extends \PHPUnit_Framework_TestCase
{
    use ElementAssertionHelperTrait;

    protected function runAssertion($expectedText, $element)
    {
        $mockElementFinder = \Phake::mock(ElementFinderInterface::class);
        $assertion = (new ElementValueEqualsToAssertion($expectedText, $mockElementFinder));
        $assertion->assert(function() use ($element) {
            return $element;
        });
    }

    public function testAssertion_GivenValueMatchesElementValue_ShouldSucceed()
    {
        \Phake::when($this->mockElement)->getAttribute('value')->thenReturn('foo');

        $this->runAssertion('foo', $this->mockElement);

        \Phake::verify($this->mockElement, \Phake::times(1))->getAttribute('value');
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testAssertion_GivenValueDoesNotMatchElementValue_ShouldFail()
    {
        \Phake::when($this->mockElement)->getAttribute('value')->thenReturn('bar');

        $this->runAssertion('foo', $this->mockElement);

        \Phake::verify($this->mockElement, \Phake::times(1))->getAttribute('value');
    }
}
