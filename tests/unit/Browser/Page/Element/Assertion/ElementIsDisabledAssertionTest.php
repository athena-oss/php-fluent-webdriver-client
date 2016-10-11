<?php

namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementIsDisabledAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;
use OLX\FluentWebDriverClient\Tests\Helpers\ElementAssertionHelperTrait;

class ElementIsDisabledAssertionTest extends \PHPUnit_Framework_TestCase
{
    use ElementAssertionHelperTrait;

    protected function runAssertion($element)
    {
        $mockElementFinder = \Phake::mock(ElementFinderInterface::class);
        $assertion = new ElementIsDisabledAssertion($mockElementFinder);
        $assertion->assert(function() use ($element) { return $element; });
    }

    /**
     * @after
     */
    public function verify()
    {
        \Phake::verify($this->mockElement, \Phake::times(1))->isEnabled();
    }

    public function testAssertion_DisabledElement_ShouldSucceed()
    {
        \Phake::when($this->mockElement)->isEnabled()->thenReturn(false);
        $this->runAssertion($this->mockElement);
    }

    /**
     * @expectedException \Exception
     */
    public function testAssertion_EnabledElement_ShouldFail()
    {
        \Phake::when($this->mockElement)->isEnabled()->thenReturn(true);
        $this->runAssertion($this->mockElement);
    }
}
