<?php
namespace OLX\FluentWebDriverClient\Browser\Page\Element\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface;
use Closure;

abstract class AbstractElementAssertion implements ElementFinderInterface
{
    /**
     * @var \OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface
     */
    private $elementFinder;

    /**
     * AbstractElementAssertion constructor.
     *
     * @param \OLX\FluentWebDriverClient\Browser\Page\Element\Find\ElementFinderInterface $elementFinder
     */
    public function __construct(ElementFinderInterface $elementFinder)
    {
        $this->elementFinder = $elementFinder;
    }

    /**
     * @return \Facebook\WebDriver\WebDriverSelect
     * @throws \OLX\FluentWebDriverClient\Exception\ElementNotExpectedException
     * @throws \OLX\FluentWebDriverClient\Exception\StopChainException
     */
    public function asDropDown()
    {
        return $this->assert(function () {
            return $this->elementFinder->asDropDown();
        });
    }

    /**
     * @return \Facebook\WebDriver\Support\Events\EventFiringWebElement
     */
    public function asHtmlElement()
    {
        return $this->assert(function () {
            return $this->elementFinder->asHtmlElement();
        });
    }

    /**
     * @codeCoverageIgnore
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    public function getBrowser()
    {
        return $this->elementFinder->getBrowser();
    }

    /**
     * @codeCoverageIgnore
     * @return \Facebook\WebDriver\WebDriverBy
     */
    public function getSearchCriteria()
    {
        return $this->elementFinder->getSearchCriteria();
    }


    /**
     * @param \Closure $getElementClosure
     *
     * @return mixed
     */
    abstract public function assert(Closure $getElementClosure);
}

