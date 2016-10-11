<?php
namespace OLX\FluentWebDriverClient\Browser\Page;

use OLX\FluentWebDriverClient\Browser\BrowserInterface;
use OLX\FluentWebDriverClient\Browser\Page\Element\ElementSelector;
use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\PageFinderWithAssertions;
use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\PageFinderWithWaits;
use OLX\FluentWebDriverClient\Browser\Page\Find\PageFinderBuilder;
use OLX\FluentWebDriverClient\Browser\Page\Find\PageFinderInterface;

/**
 * @codeCoverageIgnore
 */
class Page implements PageInterface
{
    /**
     * @var BrowserInterface
     */
    private $browser;

    /**
     * Page constructor.
     *
     * @param BrowserInterface $browser
     */
    public function __construct(BrowserInterface $browser)
    {
        $this->browser = $browser;
    }

    /**
     * @return PageFinderInterface
     */
    public function find()
    {
        return (new PageFinderBuilder($this->browser))->build();
    }

    /**
     * @return PageFinderWithAssertions
     */
    public function findAndAssertThat()
    {
        return (new PageFinderBuilder($this->browser))
            ->withAssertions()
            ->build();
    }

    /**
     * @param $timeOutInSeconds
     * @return PageFinderWithWaits
     */
    public function wait($timeOutInSeconds)
    {
        return (new PageFinderBuilder($this->browser))
            ->withWaits($timeOutInSeconds)
            ->build();
    }

    /**
     * @return \OLX\FluentWebDriverClient\Browser\Page\Element\ElementSelector
     */
    public function getElement()
    {
        return new ElementSelector($this->browser);
    }

    /**
     * Inject a snippet of JavaScript into the page for execution in the context
     * of the currently selected frame. The executed script is assumed to be
     * synchronous and the result of evaluating the script will be returned.
     *
     * @param string $script The script to inject.
     * @param array $arguments The arguments of the script.
     * @return mixed The return value of the script.
     */
    public function executeScript($script, array $arguments = array())
    {
        return $this->browser->executeScript($script, $arguments);
    }

    /**
     * Inject a snippet of JavaScript into the page for asynchronous execution in
     * the context of the currently selected frame.
     *
     * The driver will pass a callback as the last argument to the snippet, and
     * block until the callback is invoked.
     *
     * @see WebDriverExecuteAsyncScriptTestCase
     *
     * @param string $script The script to inject.
     * @param array $arguments The arguments of the script.
     * @return mixed The value passed by the script to the callback.
     */
    public function executeAsyncScript($script, array $arguments = array())
    {
        return $this->browser->executeAsyncScript($script, $arguments);
    }
}

