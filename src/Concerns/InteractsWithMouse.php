<?php

namespace Laravel\Dusk\Concerns;

/**
 * Trait InteractsWithMouse
 *
 * @property \Facebook\WebDriver\Remote\RemoteWebDriver driver
 * @property \Laravel\Dusk\ElementResolver              resolver
 */
trait InteractsWithMouse
{
    /**
     * Move the mouse over the given selector.
     *
     * @param string $selector
     *
     * @return $this
     */
    public function mouseover($selector)
    {
        $element = $this->resolver->findOrFail($selector);

        $this->driver->getMouse()->mouseMove($element->getCoordinates());

        return $this;
    }
}
