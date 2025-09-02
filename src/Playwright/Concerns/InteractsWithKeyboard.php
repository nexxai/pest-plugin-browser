<?php

declare(strict_types=1);

namespace Pest\Browser\Playwright\Concerns;

/**
 * @internal
 */
trait InteractsWithKeyboard
{
    /**
     * Start holding down key
     */
    public function keyDown(string $key): void
    {
        $response = $this->sendMessage('keyboardDown', ['key' => $key]);
        $this->processVoidResponse($response);
    }

    /**
     * Let go of key
     */
    public function keyUp(string $key): void
    {
        $response = $this->sendMessage('keyboardUp', ['key' => $key]);
        $this->processVoidResponse($response);
    }
}
