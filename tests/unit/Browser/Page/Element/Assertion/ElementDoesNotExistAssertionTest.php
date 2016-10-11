<?php

namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementDoesNotExistAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;

class ElementDoesNotExistAssertionTest extends \PHPUnit_Framework_TestCase
{
    protected function runAssertion($element)
    {
        $mockElementFinder = \Phake::mock(ElementFinderInterface::class);
        $assertion = new ElementDoesNotExistAssertion($mockElementFinder);
        $assertion->assert(function() use ($element) { return $element; });
    }

    public function testAssertion_NoMatches_ShouldSucceed()
    {
        $this->runAssertion([]);
    }

    /**
     * @expectedException \Exception
     */
    public function testAssertion_ThereAreMatches_ShouldFail()
    {
        $this->runAssertion(['element']);
    }
}
