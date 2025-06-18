<?php

declare(strict_types=1);

namespace Pest\Browser\Playwright;

/**
 * @internal
 */
final class Browser
{
    /**
     * Browser context.
     */
    private BrowserContext $context;

    /**
     * Constructs browser.
     */
    public function __construct(
        public string $guid,
    ) {
        //
    }

    /**
     * Creates a new page in the current context.
     */
    public function newPage(): Page
    {
        return $this->newContext()->newPage();
    }

    /**
     * Creates a new browser context.
     *
     * @param  array<string, mixed>  $options  Options for the context, e.g. ['hasTouch' => true]
     */
    public function newContext(array $options = []): BrowserContext
    {
        $response = Client::instance()->execute($this->guid, 'newContext', [
            ...$options,
            ...[
                'extraHTTPHeaders' => [[
                    'name' => 'X-Pest-Plugin-Browser',
                    'value' => BrowserState::packAsString(),
                ]],
            ],
        ]);

        /** @var array{result: array{context: array{guid: string|null}}} $message */
        foreach ($response as $message) {
            if (isset($message['result']['context']['guid'])) {
                $this->context = new BrowserContext($message['result']['context']['guid']);
            }
        }

        return $this->context;
    }
}
