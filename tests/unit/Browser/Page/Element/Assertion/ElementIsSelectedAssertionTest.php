<?php

namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementIsSelectedAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;
use OLX\FluentWebDriverClient\Tests\Helpers\ElementAssertionHelperTrait;

class ElementIsSelectedAssertionTest extends \PHPUnit_Framework_TestCase
{
    use ElementAssertionHelperTrait;

    protected function runAssertion($element)
    {
        $mockElementFinder = \Phake::mock(ElementFinderInterface::class);
        $assertion = (new ElementIsSelectedAssertion($mockElementFinder));
        $assertion->assert(function() use ($element) {
            return $element;
        });
    }

    public function testAssertion_SelectedElement_ShouldSucceed()
    {
        \Phake::when($this->mockElement)->isSelected()->thenReturn(true);

        $this->runAssertion($this->mockElement);

        \Phake::verify($this->mockElement, \Phake::times(1))->isSelected();
    }

    /**
     * @expectedException \OLX\FluentWebDriverClient\Exception\ElementNotSelectedException
     */
    public function testAssertion_NotSelectedElement_ShouldFail()
    {
        \Phake::when($this->mockElement)->isSelected()->thenReturn(false);

        $this->runAssertion($this->mockElement);

        \Phake::verify($this->mockElement, \Phake::times(1))->isSelected();
    }
}
