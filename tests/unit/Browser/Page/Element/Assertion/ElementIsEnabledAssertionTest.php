<?php

namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementIsEnabledAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;
use OLX\FluentWebDriverClient\Tests\Helpers\ElementAssertionHelperTrait;

class ElementIsEnabledAssertionTest extends \PHPUnit_Framework_TestCase
{
    use ElementAssertionHelperTrait;

    protected function runAssertion($element)
    {
        $mockElementFinder = \Phake::mock(ElementFinderInterface::class);
        $assertion = (new ElementIsEnabledAssertion($mockElementFinder));
        $assertion->assert(function() use ($element) {
            return $element;
        });
    }

    public function testAssertion_EnabledElement_ShouldSucceed()
    {
        \Phake::when($this->mockElement)->isEnabled()->thenReturn(true);

        $this->runAssertion($this->mockElement);

        \Phake::verify($this->mockElement, \Phake::times(1))->isEnabled();
    }

    /**
     * @expectedException \OLX\FluentWebDriverClient\Exception\ElementNotEnabledException
     */
    public function testAssertion_NotEnabledElement_ShouldFail()
    {
        \Phake::when($this->mockElement)->isEnabled()->thenReturn(false);

        $this->runAssertion($this->mockElement);

        \Phake::verify($this->mockElement, \Phake::times(1))->isEnabled();
    }
}
