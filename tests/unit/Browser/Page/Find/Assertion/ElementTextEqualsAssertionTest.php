<?php
namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Find\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Find\Assertion\ElementExistsAtLeastOnceAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Find\Assertion\ElementShouldNotExistAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Find\Assertion\ElementTextEqualsAssertion;
use Facebook\WebDriver\Remote\RemoteWebElement;

class ElementTextEqualsAssertionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function testDecorate_GetTextReturnsSameValueAsExpected_ShouldReturnTrue()
    {
        $targetClosure = function () {
            $elem1 = \Phake::mock(RemoteWebElement::class);
            \Phake::when($elem1)->getText()->thenReturn('Ipsos Lorem');
            return $elem1;
        };
        
        $assertion = new ElementTextEqualsAssertion('Ipsos Lorem');
        $this->assertTrue($assertion->decorate($targetClosure, null));
    }

    /**
     * @test
     * @expectedException \OLX\FluentWebDriverClient\Exception\UnexpectedValueException
     */
    public function testDecorate_GetTextReturnsDifferentValueThanExpected_ShouldThrowUnexpectedValueException()
    {
        $targetClosure = function () {
            $elem1 = \Phake::mock(RemoteWebElement::class);
            \Phake::when($elem1)->getText()->thenReturn('Ipsos Lorem');
            return $elem1;
        };

        $assertion = new ElementTextEqualsAssertion('not what i am expecting');
        $this->assertTrue($assertion->decorate($targetClosure, null));
    }
}
