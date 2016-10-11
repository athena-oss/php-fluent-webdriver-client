<?php
namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Find\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Find\Assertion\AtLeastOneElementAppliesToAssertion;
use Facebook\WebDriver\Remote\RemoteWebElement;

class AtLeastOneElementAppliesToAssertionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testDecorate_OneOfElementsAppliesToCriteria_ShouldReturnTrue()
    {
        $criteria = function (RemoteWebElement $element) {
            return $element->isDisplayed() === true;
        };

        $targetClosure = function () {
            $elem1 = \Phake::mock(RemoteWebElement::class);
            $elem2 = \Phake::mock(RemoteWebElement::class);
            $elem3 = \Phake::mock(RemoteWebElement::class);
            \Phake::when($elem1)->isDisplayed()->thenReturn(false);
            \Phake::when($elem2)->isDisplayed()->thenReturn(true);
            \Phake::when($elem3)->isDisplayed()->thenReturn(false);
            return [$elem1, $elem2, $elem3];
        };

        $assertion = new AtLeastOneElementAppliesToAssertion($criteria);
        $this->assertTrue($assertion->decorate($targetClosure, null));
    }

    /**
     * @test
     * @expectedException \OLX\FluentWebDriverClient\Exception\NoElementAppliesToCriteriaException
     */
    public function testDecorate_NotAllElementsAreVisible_ShouldThrowNotAllElementsApplyToCriteriaException()
    {
        $criteria = function (RemoteWebElement $element) {
            return $element->isDisplayed() === true;
        };

        $targetClosure = function () {
            $elem1 = \Phake::mock(RemoteWebElement::class);
            $elem2 = \Phake::mock(RemoteWebElement::class);
            $elem3 = \Phake::mock(RemoteWebElement::class);
            \Phake::when($elem1)->isDisplayed()->thenReturn(false);
            \Phake::when($elem2)->isDisplayed()->thenReturn(false);
            \Phake::when($elem3)->isDisplayed()->thenReturn(false);
            return [$elem1, $elem2, $elem3];
        };

        $assertion = new AtLeastOneElementAppliesToAssertion($criteria);
        $this->assertTrue($assertion->decorate($targetClosure, null));
    }

    /**
     * @expectedException \Exception
     */
    public function testDecorate_ClosureReturnsNoElements_ShouldThrowException()
    {
        $criteria = function (RemoteWebElement $element) {
            return $element->isDisplayed() === true;
        };

        $targetClosure = function () {
            return [];
        };

        $assertion = new AtLeastOneElementAppliesToAssertion($criteria);
        $this->assertTrue($assertion->decorate($targetClosure, null));
    }

    /**
     * @expectedException \Exception
     */
    public function testDecorate_ClosureReturnsSomethingOtherThanArray_ShouldThrowException()
    {
        $criteria = function (RemoteWebElement $element) {
            return $element->isDisplayed() === true;
        };

        $targetClosure = function () {
            return 1;
        };

        $assertion = new AtLeastOneElementAppliesToAssertion($criteria);
        $this->assertTrue($assertion->decorate($targetClosure, null));
    }
}
