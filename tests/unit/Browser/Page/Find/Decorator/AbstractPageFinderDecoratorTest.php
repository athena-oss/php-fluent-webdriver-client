<?php
namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Find\Decorator\ClosureHolder;

use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\AbstractPageFinderDecorator;
use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\ClosureHolder;
use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\TargetDecoratorInterface;
use OLX\FluentWebDriverClient\Browser\Page\Find\PageFinderInterface;
use OLX\FluentWebDriverClient\Exception\StopChainException;

class AbstractPageFinderDecoratorTest extends \PHPUnit_Framework_TestCase
{
    public function testDecorate_WrappingAtLeastOneDecorator_ShouldIterateThroughDecoratorsAndInvokeThem()
    {
        $fakeTargetDecorator = \Phake::mock(TargetDecoratorInterface::class);

        $pageFinder = new PageFinderDecoratorWithPublicDecorate(\Phake::mock(PageFinderInterface::class));
        $pageFinder->publicRegisterDecorator($fakeTargetDecorator);

        $this->assertTrue($pageFinder->publicDecorate(function() { return true; }, null));
        \Phake::verify($fakeTargetDecorator)->decorate(\Phake::anyParameters());
    }

    public function testDecorate_OneWrappedDecoratorThrowsStopChainException_ShouldReturnNull()
    {
        $pageFinder = new PageFinderDecoratorWithPublicDecorate(\Phake::mock(PageFinderInterface::class));
        $pageFinder->publicRegisterDecorator(new ExceptionThrowerTargetDecorator());

        $this->assertNull($pageFinder->publicDecorate(function() { }, null));
    }
}

class PageFinderDecoratorWithPublicDecorate extends AbstractPageFinderDecorator
{
    public function getBrowser()
    {
        // ...
    }

    public function publicRegisterDecorator(TargetDecoratorInterface $decorator)
    {
        $this->registerDecorator($decorator);
    }

    public function publicDecorate($targetClosure, $locator)
    {
        return $this->decorate($targetClosure, $locator);
    }
}

class ExceptionThrowerTargetDecorator implements TargetDecoratorInterface
{
    public function decorate($targetClosure, $locator)
    {
        throw new StopChainException();
    }
}
