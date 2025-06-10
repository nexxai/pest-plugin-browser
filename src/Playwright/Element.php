<?php

declare(strict_types=1);

namespace Pest\Browser\Playwright;

use Pest\Browser\Playwright\Concerns\InteractsWithPlaywright;

/**
 * @internal
 */
final class Element
{
    use InteractsWithPlaywright;

    /**
     * Constructs new element
     */
    public function __construct(
        public string $guid,
    ) {
        //
    }

    /**
     * Check if element is checked.
     */
    public function isChecked(): bool
    {
        return $this->processBooleanResponse($this->sendMessage('isChecked'));
    }

    /**
     * Check element.
     */
    public function check(): void
    {
        $this->processVoidResponse($this->sendMessage('check'));
    }

    /**
     * Uncheck element.
     */
    public function uncheck(): void
    {
        $this->processVoidResponse($this->sendMessage('uncheck'));
    }

    /**
     * Get the Attribute of the element.
     */
    public function getAttribute(string $attribute): ?string
    {
        return $this->processNullableStringResponse($this->sendMessage('getAttribute', ['name' => $attribute]));
    }

    /**
     * Fill the element with text.
     *
     * @param  array<string, mixed>|null  $options
     */
    public function fill(string $value, ?array $options = null): void
    {
        $params = array_merge(['value' => $value], $options ?? []);
        $this->processVoidResponse($this->sendMessage('fill', $params));
    }

    /**
     * Tap the element (touch screen interaction).
     *
     * @param  array<string, mixed>|null  $options
     */
    public function tap(?array $options = null): void
    {
        $this->processVoidResponse($this->sendMessage('tap', $options ?? []));
    }

    /**
     * Select options in a select element.
     *
     * @param  string|array<int, string>|array<int, string>  $values
     * @param  array<string, mixed>|null  $options
     * @return array<array-key, string>
     */
    public function selectOption(string|array $values, ?array $options = null): array
    {
        $params = array_merge(['values' => $values], $options ?? []);

        $result = $this->processArrayResponse($this->sendMessage('selectOption', $params));

        return array_map(static fn (mixed $value): string => is_scalar($value) ? (string) $value : '', $result);
    }

    /**
     * Get the text content of the element.
     */
    public function textContent(): ?string
    {
        return $this->processNullableStringResponse($this->sendMessage('textContent'));
    }

    /**
     * Get the inner text of the element.
     */
    public function innerText(): string
    {
        return $this->processStringResponse($this->sendMessage('innerText'));
    }

    /**
     * Get the inner HTML of the element.
     */
    public function innerHTML(): string
    {
        return $this->processStringResponse($this->sendMessage('innerHTML'));
    }

    /**
     * Get the input value of the element.
     *
     * @param  array<string, mixed>|null  $options
     */
    public function inputValue(?array $options = null): string
    {
        return $this->processStringResponse($this->sendMessage('inputValue', $options ?? []));
    }

    /**
     * Get the bounding box of the element.
     *
     * @return array{x: float, y: float, width: float, height: float}|null
     */
    public function boundingBox(): ?array
    {
        $result = $this->processResultResponse($this->sendMessage('boundingBox'));

        if ($result === null) {
            return null;
        }

        if (! is_array($result) || ! isset($result['x'], $result['y'], $result['width'], $result['height'])) {
            return null;
        }

        return [
            'x' => is_numeric($result['x']) ? (float) $result['x'] : 0.0,
            'y' => is_numeric($result['y']) ? (float) $result['y'] : 0.0,
            'width' => is_numeric($result['width']) ? (float) $result['width'] : 0.0,
            'height' => is_numeric($result['height']) ? (float) $result['height'] : 0.0,
        ];
    }

    /**
     * Take a screenshot of the element.
     *
     * @param  array<string, mixed>|null  $options
     */
    public function screenshot(?array $options = null): string
    {
        return $this->processBinaryResponse($this->sendMessage('screenshot', $options ?? []));
    }

    /**
     * Scroll element into view if needed.
     *
     * @param  array<string, mixed>|null  $options
     */
    public function scrollIntoViewIfNeeded(?array $options = null): void
    {
        $this->processVoidResponse($this->sendMessage('scrollIntoViewIfNeeded', $options ?? []));
    }

    /**
     * Wait for element to reach a specific state.
     *
     * @param  array<string, mixed>|null  $options
     */
    public function waitForElementState(string $state, ?array $options = null): void
    {
        $params = array_merge(['state' => $state], $options ?? []);
        $this->processVoidResponse($this->sendMessage('waitForElementState', $params));
    }

    /**
     * Select text in the element.
     *
     * @param  array<string, mixed>|null  $options
     */
    public function selectText(?array $options = null): void
    {
        $this->processVoidResponse($this->sendMessage('selectText', $options ?? []));
    }

    /**
     * Wait for a selector to appear relative to this element.
     *
     * @param  array<string, mixed>|null  $options
     */
    public function waitForSelector(string $selector, ?array $options = null): ?self
    {
        $params = array_merge(['selector' => $selector], $options ?? []);

        $element = $this->processElementCreationResponse($this->sendMessage('waitForSelector', $params));

        if (! $element instanceof self) {
            return null;
        }

        return new self($element->guid);
    }

    /**
     * Query for a single element relative to this element.
     */
    public function querySelector(string $selector): ?self
    {
        $element = $this->processElementCreationResponse($this->sendMessage('querySelector', ['selector' => $selector]));

        if (! $element instanceof self) {
            return null;
        }

        return new self($element->guid);
    }

    /**
     * Query for multiple elements relative to this element.
     *
     * @return array<self>
     */
    public function querySelectorAll(string $selector): array
    {
        $elements = $this->processMultipleElementCreationResponse($this->sendMessage('querySelectorAll', ['selector' => $selector]));

        return array_map(fn (Element $element): Element => new self($element->guid), $elements);
    }

    /**
     * Get the content frame for iframe elements.
     */
    public function contentFrame(): ?object
    {
        $result = $this->processResultResponse($this->sendMessage('contentFrame'));

        return $result !== null ? (object) ['guid' => $result] : null;
    }

    /**
     * Get the owner frame of the element.
     */
    public function ownerFrame(): ?object
    {
        $result = $this->processResultResponse($this->sendMessage('ownerFrame'));

        return $result !== null ? (object) ['guid' => $result] : null;
    }
}
