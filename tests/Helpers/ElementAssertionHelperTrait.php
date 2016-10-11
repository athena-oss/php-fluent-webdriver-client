<?php

namespace OLX\FluentWebDriverClient\Tests\Helpers;

use Facebook\WebDriver\Remote\RemoteWebElement;

trait ElementAssertionHelperTrait
{
    private $mockElement;

    public function setUp()
    {
        $this->mockElement = \Phake::mock(RemoteWebElement::class);
    }
}
