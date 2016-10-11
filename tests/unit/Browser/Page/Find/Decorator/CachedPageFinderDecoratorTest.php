<?php
namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Find\Decorator\ClosureHolder;

use Facebook\WebDriver\Remote\RemoteWebElement;
use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\CachedPageFinderDecorator;
use OLX\FluentWebDriverClient\Browser\Page\Find\PageFinderInterface;

class CachedPageFinderDecoratorTest extends \PHPUnit_Framework_TestCase
{
    public function testGet_FreshCache_ShouldForwardCallToDecoratedPageFinder()
    {
        $method = 'elementWithName';
        $identifier = 'some-name';
        $bucket = 'the-bucket';

        $fakePageFinder = \Phake::mock(PageFinderInterface::class);
        $pageFinder = new CachedPageFinderDecoratorWithFreshCache($fakePageFinder);

        $pageFinder->publicGet($method, $identifier, $bucket);
        \Phake::verify($fakePageFinder)->elementWithName($identifier);
    }

    public function testGet_WarmCache_ShouldReturnItemFromCache()
    {
        $method = 'elementWithName';
        $identifier = 'some-name';
        $bucket = 'the-bucket';

        $fakePageFinder = \Phake::mock(PageFinderInterface::class);
        $pageFinder = new CachedPageFinderDecoratorWithWarmCache($fakePageFinder);

        $pageFinder->publicGet($method, $identifier, $bucket);
        \Phake::verify($fakePageFinder, \Phake::never())->elementWithName($identifier);
    }
}

class CachedPageFinderDecoratorWithFreshCache extends CachedPageFinderDecorator
{
    public function publicGet($method, $identifier, $bucket)
    {
        $this->cache = [
            $bucket => [
            ],
        ];
        return $this->get($method, $identifier, $bucket);
    }
}

class CachedPageFinderDecoratorWithWarmCache extends CachedPageFinderDecorator
{
    public function publicGet($method, $identifier, $bucket)
    {
        $this->cache = [
            $bucket => [
                "{$method}_{$identifier}" => \Phake::mock(RemoteWebElement::class),
            ],
        ];
        return $this->get($method, $identifier, $bucket);
    }
}
