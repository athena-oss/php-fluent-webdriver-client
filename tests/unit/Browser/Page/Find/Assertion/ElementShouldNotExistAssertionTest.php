<?php
namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Find\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Find\Assertion\ElementShouldNotExistAssertion;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Remote\RemoteWebElement;

class ElementShouldNotExistAssertionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @expectedException \OLX\FluentWebDriverClient\Exception\ElementNotExpectedException
     */
    public function testDecorate_ElementCountIsNotZero_ShouldThrowElementNotExpectedException()
    {
        $targetClosure = function () {
            $elem1 = \Phake::mock(RemoteWebElement::class);
            \Phake::when($elem1)->getAttribute('age')->thenReturn(20);

            return [$elem1];
        };
        
        $assertion = new ElementShouldNotExistAssertion();
        $this->assertTrue($assertion->decorate($targetClosure, null));
    }

    /**
     * @test
     * @expectedException \OLX\FluentWebDriverClient\Exception\StopChainException
     */
    public function testDecorate_NoSuchElementExceptionIsThrown_ShouldThrowStopChainException()
    {
        $targetClosure = function () {
            throw new NoSuchElementException('abcd');
        };

        $assertion = new ElementShouldNotExistAssertion();
        $this->assertTrue($assertion->decorate($targetClosure, null));
    }
}
