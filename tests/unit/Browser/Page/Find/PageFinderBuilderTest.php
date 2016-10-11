<?php
namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Find;

use OLX\FluentWebDriverClient\Browser\BrowserInterface;
use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\PageFinderWithAssertions;
use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\PageFinderWithWaits;
use OLX\FluentWebDriverClient\Browser\Page\Find\PageFinder;
use OLX\FluentWebDriverClient\Browser\Page\Find\PageFinderBuilder;

class PageFinderBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var PageFinderBuilder */
    private $pageFinderBuilder;

    public function setUp()
    {
        $this->pageFinderBuilder = new PageFinderBuilder(\Phake::mock(BrowserInterface::class));
    }

    public function testBuild_WhenNeitherAssertionNorWaitsAreEnabled_ShouldReturnPageFinder()
    {
        $this->assertInstanceOf(PageFinder::class, $this->pageFinderBuilder->build());
    }

    public function testBuild_WhenWithAssertions_ShouldReturnPageFinderWithAssertions()
    {
        $this->pageFinderBuilder->withAssertions();
        $this->assertInstanceOf(PageFinderWithAssertions::class, $this->pageFinderBuilder->build());
    }

    public function testBuild_WhenWithWaits_ShouldReturnPageFinderWithWaits()
    {
        $this->pageFinderBuilder->withWaits(1);
        $this->assertInstanceOf(PageFinderWithWaits::class, $this->pageFinderBuilder->build());
    }
}
