<?php
/**
 * Created by PhpStorm.
 * User: pproenca
 * Date: 26/01/16
 * Time: 16:32
 */

namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Element;


use OLX\FluentWebDriverClient\Browser\BrowserInterface;
use OLX\FluentWebDriverClient\Browser\Page\Element\ElementAction;
use OLX\FluentWebDriverClient\Browser\Page\Element\ElementSelector;
use Facebook\WebDriver\Support\Events\EventFiringWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Phake;

class ElementSelectorTest extends \PHPUnit_Framework_TestCase
{
    public function testWithName_RandomName_ShouldReturnElementActionInstance()
    {
        $fakeBrowser = Phake::mock(BrowserInterface::class);

        $elementSelector = new ElementSelector($fakeBrowser);
        $elementAction   = new ElementAction(WebDriverBy::name('spinpans'), $fakeBrowser);

        $this->assertEquals($elementAction, $elementSelector->withName('spinpans'));
    }

    public function testWithId_RandomId_ShouldReturnElementActionInstance()
    {
        $fakeBrowser   = Phake::mock(BrowserInterface::class);

        $elementSelector = new ElementSelector($fakeBrowser);
        $elementAction   = new ElementAction(WebDriverBy::id('spinpans'), $fakeBrowser);

        $this->assertEquals($elementAction, $elementSelector->withId('spinpans'));
    }

    public function testWithId_RandomXpath_ShouldReturnElementActionInstance()
    {
        $fakeBrowser   = Phake::mock(BrowserInterface::class);

        $elementSelector = new ElementSelector($fakeBrowser);
        $elementAction   = new ElementAction(WebDriverBy::xpath('spinpans'), $fakeBrowser);

        $this->assertEquals($elementAction, $elementSelector->withXpath('spinpans'));
    }
}
