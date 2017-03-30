<?php

namespace OLX\FluentWebDriverClient\Browser;

use OLX\FluentWebDriverClient\Browser\Page\Page;
use OLX\FluentWebDriverClient\Browser\Page\PageInterface;
use OLX\FluentWebDriverClient\Translator\UrlTranslator;
use Facebook\WebDriver\Exception\UnknownServerException;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverElement;
use Facebook\WebDriver\WebDriverNavigation;
use Facebook\WebDriver\WebDriverOptions;
use Facebook\WebDriver\WebDriverTargetLocator;
use Facebook\WebDriver\WebDriverWait;

class Browser implements BrowserInterface
{
    /** @var RemoteWebDriver */
    private $remoteWebDriver;

    /** @var UrlTranslator */
    private $urlTranslator;

    /** @var boolean */
    private $wasCleanedUp;

    /** @var string */
    private $sessionCookie;

    /** @var BrowserDriverBuilder */
    private $remoteDriverBuilder;

    public function __construct(BrowserDriverBuilder $builder)
    {
        $this->remoteDriverBuilder = $builder;
        $this->remoteWebDriver = null;
    }

    /**
     * @codeCoverageIgnore
     */
    public function __destruct()
    {
        try {
            $this->cleanup();
        } catch (\Exception $e) {
            //void as intended
        }
    }

    public function get($url)
    {
        $this->remoteWebDriver = $this->getDriver()->get($this->urlTranslator->get($url));
        return new Page($this);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getCurrentPage()
    {
        $this->getDriver();
        return new Page($this);
    }

    public function setSession($sessionId, $path = "/", $isSecure = false)
    {
        $this->sessionCookie = [
            "name" => "PHPSESSID",
            "value" => $sessionId,
            "path"   => $path,
            "secure" => $isSecure
        ];
        $this->getDriver()->manage()->deleteCookieNamed('PHPSESSID');
        $this->getDriver()->manage()->addCookie($this->sessionCookie);
    }

    /**
     * @codeCoverageIgnore
     */
    public function deleteSession()
    {
        $this->sessionCookie = null;
        $this->getDriver()->manage()->deleteCookieNamed('PHPSESSID');
    }

    /**
     * @codeCoverageIgnore
     */
    public function getSession()
    {
        if (!empty($this->sessionCookie)) {
            return $this->sessionCookie;
        }
        return $this->getDriver()->manage()->getCookieNamed('PHPSESSID');
    }

    /**
     * @codeCoverageIgnore
     */
    public function deleteAllCookies()
    {
        $this->sessionCookie = null;
        $this->getDriver()->manage()->deleteAllCookies();
    }

    /**
     * @codeCoverageIgnore
     */
    public function cleanup()
    {
        if (!$this->wasCleanedUp && !is_null($this->remoteWebDriver)) {
            try {
                $this->remoteWebDriver->quit();
            } catch (UnknownServerException $e) {
                // if it has already TIMEOUT we don't care
                if (strpos($e->getMessage(), 'TIMEOUT') === false) {
                    throw $e;
                }
            } finally {
                $this->reset();
                $this->wasCleanedUp    = true;
                return true;
            }
        }
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function withSession($sessionId, $path = "/", $isSecure = false)
    {
        $this->setSession($sessionId, $path, $isSecure);
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getUrlTranslator()
    {
        return $this->urlTranslator;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getMouse()
    {
        return $this->getDriver()->getMouse();
    }

    /**
     * Close the current window.
     *
     * @codeCoverageIgnore
     * @return WebDriver The current instance.
     */
    public function close()
    {
        return $this->getDriver()->close();
    }

    /**
     * Get a string representing the current URL that the browser is looking at.
     *
     * @codeCoverageIgnore
     * @return string The current URL.
     */
    public function getCurrentURL()
    {
        return $this->getDriver()->getCurrentURL();
    }

    /**
     * Get the source of the last loaded page.
     *
     * @codeCoverageIgnore
     * @return string The current page source.
     */
    public function getPageSource()
    {
        return $this->getDriver()->getPageSource();
    }

    /**
     * Get the title of the current page.
     *
     * @codeCoverageIgnore
     * @return string The title of the current page.
     */
    public function getTitle()
    {
        return $this->getDriver()->getTitle();
    }

    /**
     * Return an opaque handle to this window that uniquely identifies it within
     * this driver instance.
     *
     * @codeCoverageIgnore
     * @return string The current window handle.
     */
    public function getWindowHandle()
    {
        return $this->getDriver()->getWindowHandle();
    }

    /**
     * Get all window handles available to the current session.
     *
     * @codeCoverageIgnore
     * @return array An array of string containing all available window handles.
     */
    public function getWindowHandles()
    {
        return $this->getDriver()->getWindowHandles();
    }

    /**
     * Quits this driver, closing every associated window.
     *
     * @codeCoverageIgnore
     * @return void
     */
    public function quit()
    {
        $this->getDriver()->quit();
    }

    /**
     * Take a screenshot of the current page.
     *
     * @codeCoverageIgnore
     * @param string $saveAs The path of the screenshot to be saved.
     * @return string The screenshot in PNG format.
     */
    public function takeScreenshot($saveAs = null)
    {
        return $this->getDriver()->takeScreenshot($saveAs);
    }

    /**
     * Construct a new WebDriverWait by the current WebDriver instance.
     * Sample usage:
     *
     *   $driver->wait(20, 1000)->until(
     *     WebDriverExpectedCondition::titleIs('WebDriver Page')
     *   );
     *
     * @codeCoverageIgnore
     * @param int $timeoutInSeconds
     * @param int $intervalInMillisecond
     * @return WebDriverWait
     */
    public function wait($timeoutInSeconds = 30, $intervalInMillisecond = 250)
    {
        return $this->getDriver()->wait($timeoutInSeconds, $intervalInMillisecond);
    }

    /**
     * An abstraction for managing stuff you would do in a browser menu. For
     * example, adding and deleting cookies.
     *
     * @codeCoverageIgnore
     * @return WebDriverOptions
     */
    public function manage()
    {
        return $this->getDriver()->manage();
    }

    /**
     * An abstraction allowing the driver to access the browser's history and to
     * navigate to a given URL.
     *
     * @codeCoverageIgnore
     * @return WebDriverNavigation
     * @see WebDriverNavigation
     */
    public function navigate()
    {
        return $this->getDriver()->navigate();
    }

    /**
     * Switch to a different window or frame.
     *
     * @codeCoverageIgnore
     * @return WebDriverTargetLocator
     * @see WebDriverTargetLocator
     */
    public function switchTo()
    {
        return $this->getDriver()->switchTo();
    }

    /**
     * @codeCoverageIgnore
     * @param string $name
     * @param array $params
     * @return mixed
     */
    public function execute($name, $params)
    {
        return $this->getDriver()->execute($name, $params);
    }

    /**
     * Find the first WebDriverElement within this element using the given
     * mechanism.
     *
     * @codeCoverageIgnore
     * @param WebDriverBy $locator
     * @return WebDriverElement NoSuchElementException is thrown in
     *    HttpCommandExecutor if no element is found.
     * @see WebDriverBy
     */
    public function findElement(WebDriverBy $locator)
    {
        return $this->getDriver()->findElement($locator);
    }

    /**
     * Find all WebDriverElements within this element using the given mechanism.
     *
     * @codeCoverageIgnore
     * @param WebDriverBy $locator
     * @return array A list of all WebDriverElements, or an empty array if
     *    nothing matches
     * @see WebDriverBy
     */
    public function findElements(WebDriverBy $locator)
    {
        return $this->getDriver()->findElements($locator);
    }

    /**
     * Inject a snippet of JavaScript into the page for execution in the context
     * of the currently selected frame. The executed script is assumed to be
     * synchronous and the result of evaluating the script will be returned.
     *
     * @codeCoverageIgnore
     *
     * @param string $script    The script to inject.
     * @param array  $arguments The arguments of the script.
     *
     * @return mixed The return value of the script.
     */
    public function executeScript($script, array $arguments = [])
    {
        $this->getDriver()->executeScript($script, $arguments);
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
     * @codeCoverageIgnore
     *
     * @param string $script    The script to inject.
     * @param array  $arguments The arguments of the script.
     *
     * @return mixed The value passed by the script to the callback.
     */
    public function executeAsyncScript($script, array $arguments = [])
    {
        $this->getDriver()->executeAsyncScript($script, $arguments);
    }

    /**
     * @codeCoverageIgnore
     * @return void
     */
    private function reset()
    {
        $this->sessionCookie        = null;
        $this->remoteWebDriver      = null;
        $this->urlTranslator        = null;
    }

    /**
     * @codeCoverageIgnore
     * @return RemoteWebDriver
     */
    private function getDriver()
    {
        if (is_null($this->remoteWebDriver)) {
            $this->remoteDriverBuilder->build();
            $this->remoteWebDriver = $this->remoteDriverBuilder->getRemoteWebDriver();
            $this->urlTranslator   = $this->remoteDriverBuilder->getUrlTranslator();
        }
        return $this->remoteWebDriver;
    }
}

