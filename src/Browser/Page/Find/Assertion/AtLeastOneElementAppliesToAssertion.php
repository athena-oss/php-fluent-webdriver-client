<?php
namespace OLX\FluentWebDriverClient\Browser\Page\Find\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Find\Decorator\TargetDecoratorInterface;
use OLX\FluentWebDriverClient\Exception\NoElementAppliesToCriteriaException;
use Facebook\WebDriver\Remote\RemoteWebElement;

class AtLeastOneElementAppliesToAssertion implements TargetDecoratorInterface
{
    /**
     * @var callable
     */
    private $criteria;

    /**
     * @var string
     */
    private $criteriaDescription;

    /**
     * AllElementsApplyToAssertion constructor.
     * @param callable $criteria
     * @param string $criteriaDescription
     */
    public function __construct(callable $criteria, $criteriaDescription = '<user function>')
    {
        $this->criteria            = $criteria;
        $this->criteriaDescription = $criteriaDescription;
    }

    public function decorate($targetClosure, $locator)
    {
        $elements = $targetClosure();
        $nrOfElements = sizeof($elements);

        if ($nrOfElements === 0) {
            throw new \Exception('No elements found.');
        }

        if (!is_array($elements)) {
            throw new \Exception('Elements is not an array.');
        }

        $criteria = $this->criteria;
        $nrOfElementsThatApply = array_reduce($elements, function ($carry, RemoteWebElement $currentElement) use ($criteria) {
            return $criteria($currentElement) === true ? $carry + 1 : $carry;
        }, 0);

        if ($nrOfElementsThatApply === 0) {
            throw new NoElementAppliesToCriteriaException(sprintf("No element applies to the criteria '%s'", $this->criteriaDescription));
        }

        return true;
    }
}

