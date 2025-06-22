<?php

declare(strict_types=1);

namespace Pest\Browser\Playwright;

use Pest\Browser\Exceptions\BrowserAlreadyClosedException;

/**
 * @internal
 */
final class Browser
{
    /**
     * Indicates whether the browser is closed.
     */
    private bool $closed = false;

    /**
     * Constructs browser.
     */
    public function __construct(
        public string $guid,
    ) {
        //
    }

    /**
     * Creates a new browser context.
     *
     * @param  array<string, mixed>  $options  Options for the context, e.g. ['hasTouch' => true]
     */
    public function newContext(array $options = []): BrowserContext
    {
        if ($this->closed) {
            throw new BrowserAlreadyClosedException('The browser is already closed.');
        }

        $response = Client::instance()->execute($this->guid, 'newContext', $options);

        /** @var array{result: array{context: array{guid: string|null}}} $message */
        foreach ($response as $message) {
            if (isset($message['result']['context']['guid'])) {
                $context = new BrowserContext($this, $message['result']['context']['guid']);
            }
        }

        assert(isset($context), 'Browser context was not created successfully.');

        return $context;
    }

    /**
     * Closes the browser.
     */
    public function close(): void
    {
        if ($this->closed) {
            return;
        }

        $response = Client::instance()->execute($this->guid, 'close');

        iterator_to_array($response);

        $this->closed = true;
    }

    /**
     * Checks if the browser is closed.
     */
    public function isClosed(): bool
    {
        return $this->closed;
    }
}
