<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Element\Find;

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

/**
 * Allows synchronous assertions on elements.
 *
 * Usage:
 *
 *     $browser->get($url)->getElement()->withId('the-id')
 *         ->assertThat()
 *         ->isEnabled()
 *         ->thenFind()
 *         ->asHtmlElement();
 */
class ElementFindWithAssertions
{
    /** @var ElementFinderInterface */
    private $elementFinder;

    public function __construct(ElementFinderInterface $elementFinder)
    {
        $this->elementFinder = $elementFinder;
    }

    /**
     * Asserts that the element exists in the DOM.
     *
     * @return $this
     * @throws \Exception
     */
    public function exists()
    {
        $this->elementFinder = new ElementExistsAssertion($this->elementFinder);
        return $this;
    }

    /**
     * Asserts that the element does not exist in the DOM.
     *
     * @return $this
     * @throws \Exception
     */
    public function doesNotExist()
    {
        $this->elementFinder = new ElementDoesNotExistAssertion($this->elementFinder);
        return $this;
    }

    /**
     * Asserts that the element exists in the DOM and is visible to the user.
     *
     * @return $this
     * @throws \AssertionError
     */
    public function isDisplayed()
    {
        $this->elementFinder = new ElementIsDisplayedAssertion($this->elementFinder);
        return $this;
    }

    /**
     * Asserts that the element exists in the DOM and is not visible to the user.
     *
     * @return $this
     * @throws \AssertionError
     */
    public function isHidden()
    {
        $this->elementFinder = new ElementIsHiddenAssertion($this->elementFinder);
        return $this;
    }

    /**
     * Asserts that the element exists in the DOM and is enabled.
     *
     * @return $this
     */
    public function isEnabled()
    {
        $this->elementFinder = new ElementIsEnabledAssertion($this->elementFinder);
        return $this;
    }

    /**
     * Asserts that the element exists in the DOM and is not enabled.
     *
     * @return $this
     */
    public function isDisabled()
    {
        $this->elementFinder = new ElementIsDisabledAssertion($this->elementFinder);
        return $this;
    }

    /**
     * Asserts that the element exists in the DOM and is selected.
     *
     * @return $this
     */
    public function isSelected()
    {
        $this->elementFinder = new ElementIsSelectedAssertion($this->elementFinder);
        return $this;
    }

    /**
     * Asserts that the element exists in the DOM and is not selected.
     *
     * @return $this
     * @throws \Exception
     */
    public function isDeselected()
    {
        $this->elementFinder = new ElementIsDeselectedAssertion($this->elementFinder);
        return $this;
    }

    /**
     * Asserts that the element exists in the DOM and its value equals the given value.
     *
     * @param string $expectedValue
     *
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function valueEqualTo($expectedValue)
    {
        $this->elementFinder = new ElementValueEqualsToAssertion($expectedValue, $this->elementFinder);
        return $this;
    }

    /**
     * Asserts that the element exists in the DOM and its value does not equal the given value.
     *
     * @param string $expectedValue
     *
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function valueIsNotEqualTo($value)
    {
        $this->elementFinder = new ElementValueIsNotEqualToAssertion($value, $this->elementFinder);
        return $this;
    }

    /**
     * Asserts that the element exists in the DOM and its text equals the given value.
     *
     * @param string $expectedValue
     *
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function textEqualTo($expectedValue)
    {
        $this->elementFinder = new ElementTextEqualsToAssertion($expectedValue, $this->elementFinder);
        return $this;
    }

    /**
     * Asserts that the element exists in the DOM and its text does not equal the given value.
     *
     * @param string $value
     *
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function textIsNotEqualTo($value)
    {
        $this->elementFinder = new ElementTextIsNotEqualToAssertion($value, $this->elementFinder);
        return $this;
    }

    /**
     * Allows the retrieval of the selected element.
     *
     * @return ElementFinderInterface
     */
    public function thenFind()
    {
        return $this->elementFinder;
    }
}
