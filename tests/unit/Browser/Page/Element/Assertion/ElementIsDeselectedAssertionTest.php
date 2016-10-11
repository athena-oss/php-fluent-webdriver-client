<?php

namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementIsDeselectedAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;
use OLX\FluentWebDriverClient\Tests\Helpers\ElementAssertionHelperTrait;

class ElementIsDeselectedAssertionTest extends \PHPUnit_Framework_TestCase
{
    use ElementAssertionHelperTrait;

    protected function runAssertion($element)
    {
        $mockElementFinder = \Phake::mock(ElementFinderInterface::class);
        $assertion = new ElementIsDeselectedAssertion($mockElementFinder);
        $assertion->assert(function() use ($element) { return $element; });
    }

    /**
     * @after
     */
    public function verify()
    {
        \Phake::verify($this->mockElement, \Phake::times(1))->isSelected();
    }

    public function testAssertion_DeselectedElement_ShouldSucceed()
    {
        \Phake::when($this->mockElement)->isSelected()->thenReturn(false);
        $this->runAssertion($this->mockElement);
    }

    /**
     * @expectedException \Exception
     */
    public function testAssertion_SelectedElement_ShouldFail()
    {
        \Phake::when($this->mockElement)->isSelected()->thenReturn(true);
        $this->runAssertion($this->mockElement);
    }
}
