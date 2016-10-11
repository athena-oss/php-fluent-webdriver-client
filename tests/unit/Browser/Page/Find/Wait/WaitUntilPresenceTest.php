<?php
namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Find\Wait;

use OLX\FluentWebDriverClient\Browser\BrowserInterface;
use OLX\FluentWebDriverClient\Browser\Page\Find\Wait\WaitUntilPresence;
use Exception;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Support\Events\EventFiringWebDriver;
use Facebook\WebDriver\WebDriverWait;
use Phake;
use PHPUnit_Framework_TestCase;

class WaitUntilPresenceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testDecorate_NoExceptionIsThrownByWait_ShouldReturnTrue()
    {
        $targetClosure = function () {
            return [1, 2, 3];
        };

        $fakeBrowser    = Phake::mock(BrowserInterface::class);
        $fakeDriverWait = Phake::mock(WebDriverWait::class);

        Phake::when($fakeDriverWait)->until(Phake::anyParameters())->thenReturn(true);
        Phake::when($fakeBrowser)->wait(Phake::anyParameters())->thenReturn($fakeDriverWait);

        $wait = new WaitUntilPresence($fakeBrowser, 10);
        $this->assertTrue($wait->decorate($targetClosure, null));
    }

    /**
     * @test
     * @expectedException \OLX\FluentWebDriverClient\Exception\CriteriaNotMetException
     */
    public function testDecorate_ExceptionIsThrownByWait_ShouldThrowCriteriaNotMetException()
    {
        $targetClosure = function () {
            return [];
        };

        $fakeBrowser    = Phake::mock(BrowserInterface::class);
        $fakeDriverWait = Phake::mock(WebDriverWait::class);

        Phake::when($fakeDriverWait)->until(Phake::anyParameters())->thenThrow(new Exception('Something thown by wait'));
        Phake::when($fakeBrowser)->wait(Phake::anyParameters())->thenReturn($fakeDriverWait);

        $wait = new WaitUntilPresence($fakeBrowser, 10);
        $this->assertTrue($wait->decorate($targetClosure, null));
    }

    /**
     * @expectedException \OLX\FluentWebDriverClient\Exception\NoSuchElementException
     */
    public function testValidation_CallbackReturnsAnEmptyArray_ShouldThrowNoSuchElementException()
    {
        $wait = new WaitUntilPresenceWithPublicValidation(Phake::mock(BrowserInterface::class), 10);
        $wait->publicValidate(function() { return []; }, null);
    }

    public function testValidation_CallbackReturnsANonEmptyArray_ShouldReturnTrue()
    {
        $wait = new WaitUntilPresenceWithPublicValidation(Phake::mock(BrowserInterface::class), 10);
        $this->assertTrue($wait->publicValidate(function() { return ['foo']; }, null));
    }
}

class WaitUntilPresenceWithPublicValidation extends WaitUntilPresence
{
    public function publicValidate($targetClosure, $locator = null)
    {
        return $this->validate($targetClosure, $locator);
    }
}
