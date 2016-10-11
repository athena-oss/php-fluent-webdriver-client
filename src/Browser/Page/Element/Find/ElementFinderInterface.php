<?php
namespace OLX\FluentWebDriverClient\Browser\Page\Element\Find;

interface ElementFinderInterface
{
    /**
     * @return \Facebook\WebDriver\WebDriverSelect
     */
    public function asDropDown();

    /**
     * @return \Facebook\WebDriver\Remote\RemoteWebElement
     */
    public function asHtmlElement();

    /**
     * @internal
     * @return \OLX\FluentWebDriverClient\Browser\BrowserInterface
     */
    public function getBrowser();

    /**
     * @internal
     * @return \Facebook\WebDriver\WebDriverBy
     */
    public function getSearchCriteria();
}

