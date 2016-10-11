<?php

namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\AbstractElementAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;

class AbstractElementAssertionTest extends \PHPUnit_Framework_TestCase
{
    /** @var ElementFinderInterface */
    private $mockElementFinder;

    /** @var ElementFinderInterface */
    private $assertion;

    public function setUp()
    {
        $this->mockElementFinder = \Phake::mock(ElementFinderInterface::class);
        $this->assertion = new SampleAssertion($this->mockElementFinder);
    }

    public function testAsDropDown_ShouldProxyCallToElementFinder()
    {
        $this->assertion->asDropDown();
        \Phake::verify($this->mockElementFinder, \Phake::times(1))->asDropDown();
    }

    public function testAsHtmlElement_ShouldProxyCallToElementFinder()
    {
        $this->assertion->asHtmlElement();
        \Phake::verify($this->mockElementFinder, \Phake::times(1))->asHtmlElement();
    }
}

class SampleAssertion extends AbstractElementAssertion
{
    public function assert(\Closure $getElementClosure)
    {
        $getElementClosure();
    }
}
