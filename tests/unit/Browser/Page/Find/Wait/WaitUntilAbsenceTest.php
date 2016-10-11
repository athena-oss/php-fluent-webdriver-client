<?php
namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Find\Wait;

use OLX\FluentWebDriverClient\Browser\BrowserInterface;
use OLX\FluentWebDriverClient\Browser\Page\Find\Wait\WaitUntilAbsence;
use Exception;
use Facebook\WebDriver\WebDriverWait;
use Phake;

class WaitUntilAbsenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testDecorate_NoExceptionIsThrownByWait_ShouldReturnTrue()
    {
        $targetClosure = function () {
            return [];
        };

        $fakeBrowser    = Phake::mock(BrowserInterface::class);
        $fakeDriverWait = Phake::mock(WebDriverWait::class);

        Phake::when($fakeDriverWait)->until(Phake::anyParameters())->thenReturn(true);
        Phake::when($fakeBrowser)->wait(Phake::anyParameters())->thenReturn($fakeDriverWait);

        $wait = new WaitUntilAbsence($fakeBrowser, 10);
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

        $wait = new WaitUntilAbsence($fakeBrowser, 10);
        $this->assertTrue($wait->decorate($targetClosure, null));
    }

    /**
     * @expectedException \OLX\FluentWebDriverClient\Exception\ElementNotExpectedException
     */
    public function testValidation_WhenCallbackReturnsANonEmptyArray_ShouldThrowElementNotExpectedException()
    {
        $wait = new WaitUntilAbsenceWithPublicValidation(Phake::mock(BrowserInterface::class), 10);
        $wait->publicValidate(function() { return ['foo']; }, null);
    }

    public function testValidation_WhenCallbackReturnsAnEmptyArray_ShouldReturnTrue()
    {
        $wait = new WaitUntilAbsenceWithPublicValidation(Phake::mock(BrowserInterface::class), 10);
        $this->assertTrue($wait->publicValidate(function() { return []; }, null));
    }
}

class WaitUntilAbsenceWithPublicValidation extends WaitUntilAbsence
{
    public function publicValidate($targetClosure, $locator = null)
    {
        return $this->validate($targetClosure, $locator);
    }
}
