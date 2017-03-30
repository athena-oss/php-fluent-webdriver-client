<?php
namespace OLX\FluentWebDriverClient\Tests\Browser;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverOptions;
use OLX\FluentWebDriverClient\Browser\Browser;
use OLX\FluentWebDriverClient\Browser\BrowserDriverBuilder;
use OLX\FluentWebDriverClient\Browser\Page\Page;
use OLX\FluentWebDriverClient\Translator\UrlTranslator;

class BrowserTest extends \PHPUnit_Framework_TestCase
{
    /** @var Browser */
    private $browser;

    /** @var BrowserDriverBuilder */
    private $mockBrowserDriverBuilder;

    /** @var RemoteWebDriver */
    private $mockRemoteWebDriver;

    /** @var UrlTranslator */
    private $mockUrlTranslator;

    /** @var WebDriverOptions */
    private $mockWebDriverOptions;

    public function setUp()
    {
        $this->mockBrowserDriverBuilder = \Phake::mock(BrowserDriverBuilder::class);
        $this->mockRemoteWebDriver = \Phake::mock(RemoteWebDriver::class);
        $this->mockUrlTranslator = \Phake::mock(UrlTranslator::class);
        $this->mockWebDriverOptions = \Phake::mock(WebDriverOptions::class);

        \Phake::when($this->mockRemoteWebDriver)->manage()->thenReturn($this->mockWebDriverOptions);

        \Phake::when($this->mockBrowserDriverBuilder)->getRemoteWebDriver()->thenReturn($this->mockRemoteWebDriver);
        \Phake::when($this->mockBrowserDriverBuilder)->getUrlTranslator()->thenReturn($this->mockUrlTranslator);

        $this->browser = new Browser($this->mockBrowserDriverBuilder);
    }

    public function testGet_ShouldProxyRequestToDriver()
    {
        $path = '/page.html';
        $fullUrl = 'http://example.com/page.html';

        \Phake::when($this->mockUrlTranslator)->get($path)->thenReturn($fullUrl);

        $this->assertInstanceOf(Page::class, $this->browser->get('/page.html'));

        \Phake::verify($this->mockUrlTranslator)->get($path);
        \Phake::verify($this->mockRemoteWebDriver)->get($fullUrl);
    }

    public function testSetSession_ShouldDeleteExistingCookieAndAddNewCookieToDriver()
    {
        $sessionId = 'the id';
        $path = '/test';
        $isSecure = true;

        $this->browser->setSession($sessionId, $path, $isSecure);

        \Phake::verify($this->mockWebDriverOptions)->deleteCookieNamed('PHPSESSID');

        \Phake::verify($this->mockWebDriverOptions)->addCookie([
            'name' => 'PHPSESSID',
            'value' => $sessionId,
            'path' => $path,
            'secure' => $isSecure,
        ]);
    }

    public function testCleanup_ShouldRebuildBrowserInstanceAfterCleanup() {

        $path = "/page.html";
        $pathTranslated = "http://domain/page.html";

        // init internal webdriver
        $this->browser->getCurrentPage();

        /** @var UrlTranslator $anotherUrlTranslator */
        $anotherUrlTranslator = \Phake::mock(UrlTranslator::class);
        \Phake::when($anotherUrlTranslator)->get($path)->thenReturn($pathTranslated);
        $anotherWebDriver = \Phake::mock(RemoteWebDriver::class);
        \Phake::when($this->mockBrowserDriverBuilder)->getRemoteWebDriver()->thenReturn($anotherWebDriver);
        \Phake::when($this->mockBrowserDriverBuilder)->getUrlTranslator()->thenReturn($anotherUrlTranslator);

        $this->browser->cleanup();
        $this->browser->get($path);

        \Phake::verify($this->mockBrowserDriverBuilder, \Phake::times(2))->build();
        $this->assertEquals($this->browser->getUrlTranslator(), $anotherUrlTranslator);
        \Phake::verify($anotherWebDriver)->get($pathTranslated);

    }
}
