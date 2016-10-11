<?php
namespace OLX\FluentWebDriverClient\Browser\Page\Find\Decorator;

use OLX\FluentWebDriverClient\Browser\BrowserInterface;
use OLX\FluentWebDriverClient\Browser\Page\Find\Assertion\AllElementsApplyToAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Find\Assertion\AllElementsAreHiddenAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Find\Assertion\AllElementsAreVisibleAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Find\Assertion\AtLeastOneElementAppliesToAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Find\Assertion\ElementExistsAtLeastOnceAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Find\Assertion\ElementExistsOnlyOnceAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Find\Assertion\ElementShouldNotExistAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Find\Assertion\ElementTextEqualsAssertion;
use OLX\FluentWebDriverClient\Browser\Page\Find\Assertion\ElementValueEqualsAssertion;

/**
 * @codeCoverageIgnore
 */
class PageFinderWithAssertions extends AbstractPageFinderDecorator
{
    /**
     * @return $this
     */
    public function existsOnlyOnce()
    {
        $this->registerDecorator(new ElementExistsOnlyOnceAssertion());
        return $this;
    }

    /**
     * @return $this
     */
    public function existsAtLeastOnce()
    {
        $this->registerDecorator(new ElementExistsAtLeastOnceAssertion());
        return $this;
    }

    /**
     * @return $this
     */
    public function doesNotExist()
    {
        $this->registerDecorator(new ElementShouldNotExistAssertion());
        return $this;
    }

    /**
     * @param $expectedText
     * @return $this
     */
    public function textEquals($expectedText)
    {
        $this->registerDecorator(new ElementTextEqualsAssertion($expectedText));
        return $this;
    }

    /**
     * @param $expectedValue
     * @return $this
     */
    public function valueEquals($expectedValue)
    {
        $this->registerDecorator(new ElementValueEqualsAssertion($expectedValue));
        return $this;
    }

    /**
     * @param callable $criteria
     * @param string $criteriaDescription
     * @return $this
     */
    public function allApplyTo(callable $criteria, $criteriaDescription = '<user function>')
    {
        $this->registerDecorator(new AllElementsApplyToAssertion($criteria, $criteriaDescription));
        return $this;
    }

    /**
     * @param callable $criteria
     * @param string $criteriaDescription
     * @return $this
     */
    public function anyAppliesTo(callable $criteria, $criteriaDescription = '<user function>')
    {
        $this->registerDecorator(new AtLeastOneElementAppliesToAssertion($criteria, $criteriaDescription));
        return $this;
    }

    /**
     * @return $this
     */
    public function allAreVisible()
    {
        $this->registerDecorator(new AllElementsAreVisibleAssertion());
        return $this;
    }

    /**
     * @return $this
     */
    public function allAreHidden()
    {
        $this->registerDecorator(new AllElementsAreHiddenAssertion());
        return $this;
    }

    /**
     * @return BrowserInterface
     */
    public function getBrowser()
    {
        return $this->getPageFinder()->getBrowser();
    }
}

