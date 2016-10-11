<?php

namespace OLX\FluentWebDriverClient\Browser;

use OLX\FluentWebDriverClient\Browser\Page\PageInterface;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\JavaScriptExecutor;

/**
 * Wrapper around a remote Web Driver.
 *
 * The Web Driver controls a browser by sending commands to a remote server that
 * implements the W3C WebDriver spec.
 */
interface BrowserInterface extends WebDriver, JavaScriptExecutor
{
    /**
     * Loads a web page in the current browser session and returns its PageInterface abstraction.
     *
     * @param string $url
     *
     * @return PageInterface
     */
    public function get($url);

    /**
     * Returns the PageInterface representation of the last web page loaded by this browser.
     *
     * @return PageInterface
     */
    public function getCurrentPage();

    /**
     * Recreates the current PHP session.
     *
     * @param string $sessionId
     * @param string $path
     * @param bool $isSecure
     *
     * @return void
     */
    public function setSession($sessionId, $path = "/", $isSecure = false);

    /**
     * Deletes the current PHP session.
     *
     * @return void
     */
    public function deleteSession();

    /**
     * Returns the current PHP session.
     *
     * @return array An associative array
     */
    public function getSession();

    /**
     * Deletes all cookies on the current domain.
     *
     * @return void
     */
    public function deleteAllCookies();

    /**
     * Quits the driver and closes all windows.
     *
     * @return bool
     */
    public function cleanup();

    /**
     * @deprecated Why?
     *
     * @return $this
     */
    public function withSession($sessionId, $path = "/", $isSecure = false);

    /**
     * @deprecated Exposes internal implementation details?
     *
     * @return \OLX\FluentWebDriverClient\Translator\UrlTranslator
     */
    public function getUrlTranslator();

    /**
     * @deprecated Depends on a 3rd party type
     *
     * @return \Facebook\WebDriver\Remote\RemoteMouse
     */
    public function getMouse();
}
