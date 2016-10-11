<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Element\Find;

use Facebook\WebDriver\WebDriverExpectedCondition;

/**
 * Allows asynchronous assertions on elements.
 *
 * Usage:
 *
 *     $browser->get($url)->getElement()->withId('the-id');
 *         ->wait(3)
 *         ->toBePresent()
 *         ->thenFind()
 *         ->asHtmlElement();
 */
class ElementFindWithWait
{
    /** @var int */
    private $timeInSeconds;

    /**
     * @var ElementFinderInterface
     */
    private $elementFinder;

    /**
     * @param int $timeInSeconds Timeout in seconds
     * @param ElementFinderInterface $elementFinder Element finder
     */
    public function __construct($timeInSeconds, ElementFinderInterface $elementFinder)
    {
        $this->timeInSeconds = $timeInSeconds;
        $this->elementFinder = $elementFinder;
    }

    /**
     * Asserts that the element exists in the DOM.
     *
     * @return $this
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function toBePresent()
    {
        $this->wait()->until(WebDriverExpectedCondition::presenceOfElementLocated($this->elementFinder->getSearchCriteria()));

        return $this;
    }

    /**
     * Asserts that the elements exists in the DOM and is visible to the user.
     *
     * @return $this
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function toBeVisible()
    {
        $this->wait()->until(WebDriverExpectedCondition::visibilityOfElementLocated($this->elementFinder->getSearchCriteria()));

        return $this;
    }

    /**
     * Asserts that the element exists in the DOM and is not visible to the user.
     *
     * @return $this
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function toBeInvisible()
    {
        $this->wait()->until(WebDriverExpectedCondition::invisibilityOfElementLocated($this->elementFinder->getSearchCriteria()));

        return $this;
    }

    /**
     * Asserts that the element exists in the DOM and is clickable by the user.
     *
     * @return $this
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function toBeClickable()
    {
        $this->wait()->until(WebDriverExpectedCondition::elementToBeClickable($this->elementFinder->getSearchCriteria()));

        return $this;
    }

    /**
     * Asserts that the element exists in the DOM and is selected.
     *
     * @return $this
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     * @throws \Facebook\WebDriver\Exception\TimeOutException
     */
    public function toBeSelected()
    {
        $this->wait()->until(WebDriverExpectedCondition::elementToBeSelected($this->elementFinder->getSearchCriteria()));

        return $this;
    }

    /**
     * @return \Facebook\WebDriver\WebDriverWait
     */
    private function wait()
    {
        return $this->elementFinder->getBrowser()->wait($this->timeInSeconds, 250);
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

