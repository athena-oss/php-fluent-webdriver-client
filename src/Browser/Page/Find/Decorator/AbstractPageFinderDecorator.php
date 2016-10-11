<?php
namespace OLX\FluentWebDriverClient\Browser\Page\Find\Decorator;

use OLX\FluentWebDriverClient\Browser\Page\Find\PageFinderInterface;
use OLX\FluentWebDriverClient\Exception\StopChainException;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriverBy;

abstract class AbstractPageFinderDecorator implements PageFinderInterface
{
    /**
     * @var PageFinderInterface
     */
    private $pageFinder;

    /**
     * @var TargetDecoratorInterface[]
     */
    private $decorators;

    public function __construct(PageFinderInterface $pageFinder)
    {
        $this->pageFinder  = $pageFinder;
        $this->decorators = [];
    }

    /**
     * @codeCoverageIgnore
     * @param $name
     * @return RemoteWebElement
     */
    public function elementWithName($name)
    {
        return $this->makeDecorateMethod('elementWithName', $name, WebDriverBy::name($name));
    }

    /**
     * @codeCoverageIgnore
     * @param $name
     * @return RemoteWebElement[]
     */
    public function elementsWithName($name)
    {
        return $this->makeDecorateMethod('elementsWithName', $name, WebDriverBy::name($name));
    }

    /**
     * @codeCoverageIgnore
     * @param $id
     * @return RemoteWebElement
     */
    public function elementWithId($id)
    {
        return $this->makeDecorateMethod('elementWithId', $id, WebDriverBy::id($id));
    }

    /**
     * @codeCoverageIgnore
     * @param $id
     * @return RemoteWebElement[]
     */
    public function elementsWithId($id)
    {
        return $this->makeDecorateMethod('elementsWithId', $id, WebDriverBy::id($id));
    }

    /**
     * @codeCoverageIgnore
     * @param $css
     * @return RemoteWebElement
     */
    public function elementWithCss($css)
    {
        return $this->makeDecorateMethod('elementWithCss', $css, WebDriverBy::cssSelector($css));
    }

    /**
     * @codeCoverageIgnore
     * @param $css
     * @return RemoteWebElement[]
     */
    public function elementsWithCss($css)
    {
        return $this->makeDecorateMethod('elementsWithCss', $css, WebDriverBy::cssSelector($css));
    }

    /**
     * @codeCoverageIgnore
     * @param $xpath
     * @return RemoteWebElement
     */
    public function elementWithXpath($xpath)
    {
        return $this->makeDecorateMethod('elementWithXpath', $xpath, WebDriverBy::xpath($xpath));
    }

    /**
     * @codeCoverageIgnore
     * @param $xpath
     * @return RemoteWebElement[]
     */
    public function elementsWithXpath($xpath)
    {
        return $this->makeDecorateMethod('elementsWithXpath', $xpath, WebDriverBy::xpath($xpath));
    }


    /**
     * @codeCoverageIgnore
     * @param $methodName
     * @param $value
     * @param $locator
     * @return mixed
     */
    protected function makeDecorateMethod($methodName, $value, $locator)
    {
        return $this->decorate(
            function () use ($methodName, $value) {
                return $this->pageFinder->$methodName($value);
            },
            $locator
        );
    }


    /**
     * @codeCoverageIgnore
     * @return PageFinderInterface
     */
    public function getPageFinder()
    {
        return $this->pageFinder;
    }

    /**
     * @param TargetDecoratorInterface $decorator
     */
    protected function registerDecorator(TargetDecoratorInterface $decorator)
    {
        $this->decorators[] = $decorator;
    }

    /**
     * @param $targetClosure
     * @param $locator
     * @return mixed
     */
    protected function decorate($targetClosure, $locator)
    {
        try {
            $closureHolder = new ClosureHolder($targetClosure);
            foreach ($this->decorators as $decorator) {
                $decorator->decorate($closureHolder, $locator);
            }
        } catch (StopChainException $e) {
            return null;
        }

        return $closureHolder->get();
    }
}

