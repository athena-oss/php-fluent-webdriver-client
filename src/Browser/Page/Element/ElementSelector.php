<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Element;

use OLX\FluentWebDriverClient\Browser\BrowserInterface;
use Facebook\WebDriver\WebDriverBy;

/**
 * Allows filtering of elements by using selectors.
 *
 * Usage:
 *
 *     // by the element name property
 *     $browser->get($url)->getElement()->withName('some-name');
 *
 *     // by the element id property
 *     $browser->get($url)->getElement()->withId('some-id');
 *
 *     // by XPath selector
 *     $browser->get($url)->getElement()->withXpath('//p');
 *
 *     // by CSS selector
 *     $browser->get($url)->getElement()->withCss('#some-id p');
 *
 *     // by visible anchor text
 *     $browser->get($url)->getElement()->withLinkText('the link text');
 *
 * @codeCoverageIgnore
 */
class ElementSelector
{
    /** @var \Facebook\WebDriver\Remote\RemoteWebDriver */
    private $browser;

    /**
     * @param BrowserInterface $driver
     */
    public function __construct(BrowserInterface $driver)
    {
        $this->browser = $driver;
    }

    /**
     * Filters elements by the element name property.
     *
     * @param string $name
     *
     * @return ElementAction
     */
    public function withName($name)
    {
        return new ElementAction(WebDriverBy::name($name), $this->browser);
    }

    /**
     * Filters elements by the element id property.
     *
     * @param string $elementId
     *
     * @return ElementAction
     */
    public function withId($elementId)
    {
        return new ElementAction(WebDriverBy::id($elementId), $this->browser);
    }

    /**
     * Filters elements by XPath selector.
     *
     * @param string $xPath
     *
     * @return ElementAction
     */
    public function withXpath($xPath)
    {
        return new ElementAction(WebDriverBy::xpath($xPath), $this->browser);
    }

    /**
     * Filters elements by CSS selector.
     *
     * @param string $cssSelector
     *
     * @return ElementAction
     */
    public function withCss($cssSelector)
    {
        return new ElementAction(WebDriverBy::cssSelector($cssSelector), $this->browser);
    }

    /**
     * Filters elements by visible anchor text.
     *
     * @param $linkText
     * @return ElementAction
     */
    public function withLinkText($linkText){
        return new ElementAction(WebDriverBy::linkText($linkText),$this->browser);
    }
}

