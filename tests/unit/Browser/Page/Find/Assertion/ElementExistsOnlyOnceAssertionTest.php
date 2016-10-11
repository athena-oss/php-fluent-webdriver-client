<?php

namespace OLX\FluentWebDriverClient\Tests\Browser\Page\Find\Assertion;

use OLX\FluentWebDriverClient\Browser\Page\Find\Assertion\ElementExistsOnlyOnceAssertion;

class ElementExistsOnlyOnceAssertionTest extends \PHPUnit_Framework_TestCase
{
    protected function runAssertion($closure, $locator)
    {
        (new ElementExistsOnlyOnceAssertion())->decorate($closure, $locator);
    }

    /**
     * @dataProvider closuresWhichReturnArrayOfLengthOne
     */
    public function testAssertion_ClosureWhichReturnsArrayOfLengthOne_ShouldSucceed($closure)
    {
        $this->runAssertion($closure, []);
    }

    /**
     * @dataProvider closuresWhichReturnArrayOfLengthOtherThanOne
     * @expectedException \Exception
     */
    public function testAssertion_ClosureWhichReturnsArrayOfLengthOtherThanOne_ShouldFail($closure)
    {
        $this->runAssertion($closure, []);
    }

    public function closuresWhichReturnArrayOfLengthOne()
    {
        return [
            [ function() { return ['foo']; } ],
            [ function() { return ['bar']; } ],
        ];
    }

    public function closuresWhichReturnArrayOfLengthOtherThanOne()
    {
        return [
            [ function() { return []; } ],
            [ function() { return ['foo', 'bar']; } ],
        ];
    }
}
