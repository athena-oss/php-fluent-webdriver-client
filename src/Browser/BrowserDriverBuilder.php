<?php
namespace OLX\FluentWebDriverClient\Browser;

use Facebook\WebDriver\Chrome\ChromeOptions;
use OLX\FluentWebDriverClient\Exception\UnsupportedBrowserException;
use OLX\FluentWebDriverClient\Translator\UrlTranslator;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;

/**
 * Provides a fluent interface for initializing Facebook RemoteWebDriver objects.
 *
 * Usage:
 *
 *     $driver = (new BrowserDriverBuilder('http://localhost:4444/wd/hub'))
 *         ->withType('phantomjs')
 *         ->build()
 *         ->getRemoteWebDriver();
 *
 * @codeCoverageIgnore
 */
class BrowserDriverBuilder
{
    /** @var RemoteWebDriver */
    private $remoteWebDriver;

    /** @var UrlTranslator */
    private $urlTranslator;

    /** @var string */
    private $type;

    /** @var string */
    private $url;

    /** @var array */
    private $urls;

    /** @var array */
    private $extraCapabilities;

    /** @var int */
    private $implicitTimeout;

    /** @var int */
    private $connectionTimeout;

    /** @var int */
    private $requestTimeout;

    /**
     * @var array
     */
    private $chromeOptions;

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
        $this->extraCapabilities = [];
        $this->urls = [];
        $this->chromeOptions = [];
    }

    public function __destruct()
    {
        $this->remoteWebDriver = null;
    }

    /**
     * Sets the given type and returns self.
     *
     * @param string $type
     *
     * @return $this
     */
    public function withType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Sets the given proxy settings and returns self.
     *
     * @param array $proxySettings
     *
     * @return $this
     */
    public function withProxySettings($proxySettings)
    {
        if (!empty($proxySettings)) {
            $this->extraCapabilities[WebDriverCapabilityType::PROXY] = [
                'proxyType' => $proxySettings['proxyType'],
                'httpProxy' => $proxySettings['httpProxy'],
                'sslProxy' => $proxySettings['sslProxy'],
            ];
        }
        return $this;
    }

    /**
     * Sets the given urls and returns self.
     *
     * @param $urls
     *
     * @return $this
     */
    public function withUrls(array $urls)
    {
        $this->urls = $urls;
        return $this;
    }

    /**
     * @todo Can we rename this to implicit wait, to keep the same lingo that Selenium uses?
     *
     * Sets the given implicit timeout and returns self.
     *
     * @param int $timeout
     *
     * @return $this
     */
    public function withImplicitTimeout($timeout)
    {
        $this->implicitTimeout = $timeout;
        return $this;
    }

    /**
     * Sets the given connection timeout and returns self.
     *
     * @param int $seconds
     *
     * @return $this
     */
    public function withConnectionTimeout($seconds)
    {
        $this->connectionTimeout = $seconds ? $seconds * 1000 : null;
        return $this;
    }

    /**
     * Sets the given request timeout and returns self.
     *
     * @param int $seconds
     *
     * @return $this
     */
    public function withRequestTimeout($seconds)
    {
        $this->requestTimeout = $seconds ? $seconds * 1000 : null;
        return $this;
    }

    /**
     * Sets the given extra capabilities and returns self.
     *
     * @param array $capabilities
     *
     * @return $this
     */
    public function withExtraCapabilities(array $capabilities)
    {
        $this->extraCapabilities = array_merge($this->extraCapabilities, $capabilities);
        return $this;
    }

    public function withChromeOptionsArguments(array $arguments){
        $this->chromeOptions = $arguments;
        return $this;
    }

    /**
     * Builds a Facebook RemoteWebDriver.
     *
     * @throws UnsupportedBrowserException
     *
     * @return $this
     */
    public function build()
    {
        $capabilities = $this->makeCapabilities($this->type, $this->extraCapabilities);

        $this->remoteWebDriver = RemoteWebDriver::create(
            $this->url,
            $capabilities,
            $this->connectionTimeout,
            $this->requestTimeout
        );

        // define web driver configurations before being decorated
        if ($this->implicitTimeout > 0) {
            $this->remoteWebDriver->manage()->timeouts()->implicitlyWait($this->implicitTimeout);
        }

        // translator
        $baseUrlId = UrlTranslator::BASE_URL_IDENTIFIER;
        $baseUrl = array_key_exists($baseUrlId, $this->urls) ? $this->urls[$baseUrlId] : null;
        $this->urlTranslator = new UrlTranslator($this->urls, $baseUrl);

        return $this;
    }

    /**
     * Returns the driver built during the call to build().
     *
     * @return RemoteWebDriver
     */
    public function getRemoteWebDriver()
    {
        return $this->remoteWebDriver;
    }

    /**
     * @return UrlTranslator
     */
    public function getUrlTranslator()
    {
        return $this->urlTranslator;
    }

    /**
     * @param string $browserType
     * @param array  $desiredCapabilities
     *
     * @return array
     * @throws \OLX\FluentWebDriverClient\Exception\UnsupportedBrowserException
     */
    private function makeCapabilities($browserType, $desiredCapabilities = [])
    {
        switch ($browserType) {
            case 'chrome':
                $chromeCaps = DesiredCapabilities::chrome();
                $options = new ChromeOptions();

                $options->addArguments($this->chromeOptions);
                $chromeCaps->setCapability(ChromeOptions::CAPABILITY,$options);

                return array_merge(
                    $chromeCaps->toArray(),$desiredCapabilities
                );
            case 'firefox':
                return array_merge(
                    DesiredCapabilities::firefox()->toArray(),
                    $desiredCapabilities
                );
            case 'phantomjs':
                return array_merge(
                    DesiredCapabilities::phantomjs()->toArray(),
                    $desiredCapabilities
                );
            default:
                throw new UnsupportedBrowserException("Browser not supported '$browserType'");
        }
    }
}

