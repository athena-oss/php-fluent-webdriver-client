<?php

namespace OLX\FluentWebDriverClient\Browser\Page;

use OLX\FluentWebDriverClient\Browser\Page\Element\ElementSelector;
use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\PageFinderWithWaits;
use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\PageFinderWithAssertions;
use OLX\FluentWebDriverClient\Browser\Page\Find\PageFinderInterface;
use Facebook\WebDriver\JavaScriptExecutor;

/**
 * Defines the PageObject abstraction around a web page as a fluent API.
 *
 * Reference: {@link http://martinfowler.com/bliki/PageObject.html}
 */
interface PageInterface extends JavaScriptExecutor
{
    /**
     * @return PageFinderInterface
     */
    public function find();

    /**
     * @return PageFinderWithAssertions
     */
    public function findAndAssertThat();

    /**
     * @param $timeOutInSeconds
     * @return PageFinderWithWaits
     */
    public function wait($timeOutInSeconds);

    /**
     * @return ElementSelector
     */
    public function getElement();
}
