<?php

declare(strict_types=1);

namespace Pest\Browser\Api\Concerns;

trait CanTakeScreenshots
{
    /**
     * Performs a screenshot of the current page and saves it to the given path.
     */
    public function screenshot(bool $fullPage = true, ?string $filename = null): self
    {
        $filename = $this->getFilename($filename);

        $this->page->screenshot($fullPage, $filename);

        return $this;
    }

    /**
     * Performs a screenshot of an element and saves it to the given path.
     */
    public function screenshotElement(string $selector, ?string $filename = null): self
    {
        $filename = $this->getFilename($filename);

        $this->page->screenshotElement($selector, $filename);

        return $this;
    }

    private function getFilename(?string $filename = null): string
    {
        return is_string($filename) ? $filename : 'screenshot-'.date('Y_m_d_H_i_s_u').'.png';
    }
}
