<?php
/**
 * Created by PhpStorm.
 * User: pproenca
 * Date: 28/01/16
 * Time: 18:45
 */

namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Element\Find;

use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementDoesNotExistAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementExistsAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementIsDeselectedAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementIsDisabledAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementIsDisplayedAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementIsEnabledAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementIsHiddenAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementIsSelectedAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementTextEqualsToAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementTextIsNotEqualToAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementValueEqualsToAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Assertion\ElementValueIsNotEqualToAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFindWithAssertions;
use Phake;

class ElementFindWithAssertionsTest extends \PHPUnit_Framework_TestCase
{
    public function testExists_MethodIsCalled_ShouldChangeElementFinderPropertyToElementExistsAssertionInstance()
    {
        $fakeElementFinder = Phake::mock(ElementFinderInterface::class);
        $expectedDecorator = new ElementExistsAssertion($fakeElementFinder);

        $elementFinder = new ElementFindWithAssertions($fakeElementFinder);
        $elementFinder->exists();

        $this->assertEquals($expectedDecorator, $elementFinder->thenFind());
    }

    public function testDoesNotExist_MethodIsCalled_ShouldChangeElementFinderPropertyToElementDoesNotExistAssertionInstance()
    {
        $fakeElementFinder = Phake::mock(ElementFinderInterface::class);
        $expectedDecorator = new ElementDoesNotExistAssertion($fakeElementFinder);

        $elementFinder = new ElementFindWithAssertions($fakeElementFinder);
        $elementFinder->doesNotExist();

        $this->assertEquals($expectedDecorator, $elementFinder->thenFind());
    }

    public function testIsDisplayed_MethodIsCalled_ShouldChangeElementFinderPropertyToElementIsDisplayedAssertionInstance()
    {
        $fakeElementFinder = Phake::mock(ElementFinderInterface::class);
        $expectedDecorator = new ElementIsDisplayedAssertion($fakeElementFinder);

        $elementFinder = new ElementFindWithAssertions($fakeElementFinder);
        $elementFinder->isDisplayed();

        $this->assertEquals($expectedDecorator, $elementFinder->thenFind());
    }

    public function testIsHidden_MethodIsCalled_ShouldChangeElementFinderPropertyToElementIsHiddenAssertionInstance()
    {
        $fakeElementFinder = Phake::mock(ElementFinderInterface::class);
        $expectedDecorator = new ElementIsHiddenAssertion($fakeElementFinder);

        $elementFinder = new ElementFindWithAssertions($fakeElementFinder);
        $elementFinder->isHidden();

        $this->assertEquals($expectedDecorator, $elementFinder->thenFind());
    }

    public function testIsEnabled_MethodIsCalled_ShouldChangeElementFinderPropertyToElementIsEnabledAssertionInstance()
    {
        $fakeElementFinder = Phake::mock(ElementFinderInterface::class);
        $expectedDecorator = new ElementIsEnabledAssertion($fakeElementFinder);

        $elementFinder = new ElementFindWithAssertions($fakeElementFinder);
        $elementFinder->isEnabled();

        $this->assertEquals($expectedDecorator, $elementFinder->thenFind());
    }

    public function testIsDisabled_MethodIsCalled_ShouldChangeElementFinderPropertyToElementIsDisabledAssertionInstance()
    {
        $fakeElementFinder = Phake::mock(ElementFinderInterface::class);
        $expectedDecorator = new ElementIsDisabledAssertion($fakeElementFinder);

        $elementFinder = new ElementFindWithAssertions($fakeElementFinder);
        $elementFinder->isDisabled();

        $this->assertEquals($expectedDecorator, $elementFinder->thenFind());
    }

    public function testIsSelected_MethodIsCalled_ShouldChangeElementFinderPropertyToElementIsSelectedAssertionInstance()
    {
        $fakeElementFinder = Phake::mock(ElementFinderInterface::class);
        $expectedDecorator = new ElementIsSelectedAssertion($fakeElementFinder);

        $elementFinder = new ElementFindWithAssertions($fakeElementFinder);
        $elementFinder->isSelected();

        $this->assertEquals($expectedDecorator, $elementFinder->thenFind());
    }

    public function testIsDeselected_MethodIsCalled_ShouldChangeElementFinderPropertyToElementIsDeselectedAssertionInstance()
    {
        $fakeElementFinder = Phake::mock(ElementFinderInterface::class);
        $expectedDecorator = new ElementIsDeselectedAssertion($fakeElementFinder);

        $elementFinder = new ElementFindWithAssertions($fakeElementFinder);
        $elementFinder->isDeselected();

        $this->assertEquals($expectedDecorator, $elementFinder->thenFind());
    }

    public function testValueEqualTo_MethodIsCalledWithExpectedValue_ShouldChangeElementFinderPropertyToElementValueEqualsToAssertionInstance()
    {
        $expectedString    = 'my string';
        $fakeElementFinder = Phake::mock(ElementFinderInterface::class);
        $expectedDecorator = new ElementValueEqualsToAssertion($expectedString, $fakeElementFinder);

        $elementFinder = new ElementFindWithAssertions($fakeElementFinder);
        $elementFinder->valueEqualTo($expectedString);

        $this->assertEquals($expectedDecorator, $elementFinder->thenFind());
    }

    public function testValueIsNotEqualTo_MethodIsCalledWithExpectedValue_ShouldChangeElementFinderPropertyToElementValueIsNotEqualToAssertionInstance()
    {
        $expectedString    = 'my string';
        $fakeElementFinder = Phake::mock(ElementFinderInterface::class);
        $expectedDecorator = new ElementValueIsNotEqualToAssertion($expectedString, $fakeElementFinder);

        $elementFinder = new ElementFindWithAssertions($fakeElementFinder);
        $elementFinder->valueIsNotEqualTo($expectedString);

        $this->assertEquals($expectedDecorator, $elementFinder->thenFind());
    }

    public function testTextEqualTo_MethodIsCalledWithExpectedValue_ShouldChangeElementFinderPropertyToElementTextEqualsToAssertionInstance()
    {
        $expectedString    = 'my string';
        $fakeElementFinder = Phake::mock(ElementFinderInterface::class);
        $expectedDecorator = new ElementTextEqualsToAssertion($expectedString, $fakeElementFinder);

        $elementFinder = new ElementFindWithAssertions($fakeElementFinder);
        $elementFinder->textEqualTo($expectedString);

        $this->assertEquals($expectedDecorator, $elementFinder->thenFind());
    }

    public function testTextIsNotEqualTo_MethodIsCalledWithExpectedValue_ShouldChangeElementFinderPropertyToElementTextIsNotEqualToAssertionInstance()
    {
        $expectedString    = 'my string';
        $fakeElementFinder = Phake::mock(ElementFinderInterface::class);
        $expectedDecorator = new ElementTextIsNotEqualToAssertion($expectedString, $fakeElementFinder);

        $elementFinder = new ElementFindWithAssertions($fakeElementFinder);
        $elementFinder->textIsNotEqualTo($expectedString);

        $this->assertEquals($expectedDecorator, $elementFinder->thenFind());
    }
}
