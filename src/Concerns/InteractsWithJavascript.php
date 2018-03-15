<?php

namespace Laravel\Dusk\Concerns;

/**
 * Trait InteractsWithJavascript
 *
 * @property \Facebook\WebDriver\Remote\RemoteWebDriver driver
 * @property \Laravel\Dusk\ElementResolver              resolver
 */
trait InteractsWithJavascript
{
    /**
     * Execute JavaScript within the browser.
     *
     * @param string|array $scripts
     *
     * @return array
     */
    public function script($scripts)
    {
        return collect((array) $scripts)->map(function ($script) {
            return $this->driver->executeScript($script);
        })->all();
    }
}
