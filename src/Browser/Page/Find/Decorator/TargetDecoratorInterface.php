<?php

namespace OLX\FluentWebDriverClient\Browser\Page\Find\Decorator;

/**
 * @todo docs
 */
interface TargetDecoratorInterface
{
    /**
     * @todo docs
     *
     * @param $targetClosure
     * @param $locator
     * @return mixed
     */
    public function decorate($targetClosure, $locator);
}
