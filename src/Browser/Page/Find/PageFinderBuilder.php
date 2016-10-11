<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Find;

use OLX\FluentWebDriverClient\Browser\BrowserInterface;
use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\PageFinderWithAssertions;
use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\PageFinderWithWaits;

/**
 * Class PageFinderBuilder is a fluent interface for constructing PageFinder objects.
 */
class PageFinderBuilder
{
    /** @var BrowserInterface */
    private $browser;

    /** @var boolean */
    private $isWithAssertions;

    /** @var boolean */
    private $isWithWaits;

    /** @var int */
    private $timeOutInSeconds;

    public function __construct(BrowserInterface $remoteWebDriver)
    {
        $this->browser = $remoteWebDriver;
        $this->isWithWaits = false;
        $this->isWithAssertions = false;
    }

    /**
     * Sets assertions to true and returns self.
     *
     * @return $this
     */
    public function withAssertions()
    {
        $this->isWithAssertions = true;

        return $this;
    }

    /**
     * Sets waits to true, sets the timeout in seconds and returns self.
     *
     * @param int $timeOutInSeconds
     * @return $this
     */
    public function withWaits($timeOutInSeconds)
    {
        $this->isWithWaits = true;
        $this->timeOutInSeconds = $timeOutInSeconds;

        return $this;
    }

    /**
     * Creates and returns a new PageFinder object according to the current builder state.
     *
     * @return PageFinderInterface
     */
    public function build()
    {
        $pageFinder = new PageFinder($this->browser);

        if ($this->isWithAssertions) {
            $pageFinder = new PageFinderWithAssertions($pageFinder);
        }

        if ($this->isWithWaits) {
            $pageFinder = new PageFinderWithWaits($pageFinder, $this->timeOutInSeconds);
        }

        return $pageFinder;
    }
}
