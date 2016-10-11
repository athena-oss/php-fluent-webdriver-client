<?php

namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementExistsAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;

class ElementExistsAssertionTest extends \PHPUnit_Framework_TestCase
{
    protected function runAssertion($element)
    {
        $mockElementFinder = \Phake::mock(ElementFinderInterface::class);
        $assertion = new ElementExistsAssertion($mockElementFinder);
        $assertion->assert(function() use ($element) { return $element; });
    }

    public function testAssertion_ThereAreMatches_ShouldSucceed()
    {
        $this->runAssertion(['element']);
    }

    /**
     * @expectedException \Exception
     */
    public function testAssertion_NoMatches_ShouldFail()
    {
        $this->runAssertion([]);
    }
}
