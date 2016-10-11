<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Element;

use OLX\FluentWebDriverClient\Browser\BrowserInterface;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFind;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFindWithAssertions;
use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFindWithWait;
use Facebook\WebDriver\WebDriverBy;

/**
 * Provides entry points for registering element assertions and/or returning the currently selected elements.
 *
 * Usage:
 *
 *     // synchronous assertion
 *     $browser->get($url)->getElement()->withId('the-id')
 *         ->assertThat()
 *         ->isEnabled()
 *         ->thenFind()
 *         ->asHtmlElement();
 *
 *     // asynchronous assertion
 *     $browser->get($url)->getElement()->withId('the-id')
 *         ->wait(3)
 *         ->toBePresent()
 *         ->thenFind()
 *         ->asHtmlElement();
 *
 *     // simply filter and assign the selected RemoteWebElement to a variable
 *     $el = $browser->get($url)->getElement()->withId('the-id')
 *         ->thenFind()
 *         ->asHtmlElement();
 */
class ElementAction
{
    /**
     * @var \Facebook\WebDriver\WebDriverBy
     */
    private $findBy;

    /**
     * @var \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    private $browser;

    /**
     * @param \Facebook\WebDriver\WebDriverBy $findBy
     * @param BrowserInterface $browser
     */
    public function __construct(WebDriverBy $findBy, BrowserInterface $browser)
    {
        $this->findBy = $findBy;
        $this->browser = $browser;
    }

    /**
     * Allows the retrieval of the selected element.
     *
     * @return ElementFinderInterface
     */
    public function thenFind()
    {
        return new ElementFind($this->findBy, $this->browser);
    }

    /**
     * Creates and returns a synchronous assertion context.
     *
     * @return ElementFindWithAssertions
     */
    public function assertThat()
    {
        return new ElementFindWithAssertions($this->thenFind());
    }

    /**
     * Creates and returns an asynchronous assertion context.
     *
     * @param int $timeInSeconds
     *
     * @return ElementFindWithWait
     */
    public function wait($timeInSeconds)
    {
        return new ElementFindWithWait($timeInSeconds, $this->thenFind());
    }
}

