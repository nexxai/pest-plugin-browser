<?php

declare(strict_types=1);

use Pest\Browser\Api\Webpage;
use Pest\Browser\Browsable;
use Pest\Browser\Playwright\Locator;
use Pest\Browser\Playwright\Page;
use Pest\Expectation;
use Pest\Mixins\Expectation as ExpectationMixin;
use Pest\Plugin;

Plugin::uses(Browsable::class);

if (! function_exists('visit')) {
    /**
     * Browse to the given URL.
     *
     * @param  array<string, mixed>  $options
     */
    function visit(?string $url = null, array $options = []): Webpage
    {
        return test()->visit($url, $options);
    }
}

expect()->extend('toHaveTitle', function (string $title): Expectation {
    /** @var ExpectationMixin<Locator> $this */

    /** @var ExpectationMixin<Locator> $this */
    if (! $this->value instanceof Page) {
        throw new InvalidArgumentException('Expected value to be an Page instance');
    }

    expect($this->value->title())->toBe($title);

    return $this;
});

expect()->extend('toHaveText', function (string $content): Expectation {
    /** @var ExpectationMixin<Locator> $this */

    /** @var ExpectationMixin<Locator> $this */
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be an Locator instance');
    }

    expect($this->value->textContent())->toContain($content);

    return $this;
});

expect()->extend('toBeChecked', function (): Expectation {
    /** @var ExpectationMixin<Locator> $this */
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be a Locator instance');
    }

    expect($this->value->isChecked())->toBeTrue();

    return $this;
});

expect()->extend('toBeVisible', function (): Expectation {
    /** @var ExpectationMixin<Locator> $this */
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be a Locator instance');
    }

    expect($this->value->isVisible())->toBeTrue();

    return $this;
});

expect()->extend('toBeEnabled', function (): Expectation {
    /** @var ExpectationMixin<Locator> $this */
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be a Locator instance');
    }

    expect($this->value->isEnabled())->toBeTrue();

    return $this;
});

expect()->extend('toBeDisabled', function (): Expectation {

    /** @var ExpectationMixin<Locator> $this */
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be a Locator instance');
    }

    expect($this->value->isDisabled())->toBeTrue();

    return $this;
});

expect()->extend('toBeEditable', function (): Expectation {
    /** @var ExpectationMixin<Locator> $this */
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be a Locator instance');
    }

    expect($this->value->isEditable())->toBeTrue();

    return $this;
});

expect()->extend('toBeHidden', function (): Expectation {
    /** @var ExpectationMixin<Locator> $this */
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be a Locator instance');
    }

    expect($this->value->isHidden())->toBeTrue();

    return $this;
});

expect()->extend('toHaveId', function (string $id): Expectation {

    /** @var ExpectationMixin<Locator> $this */
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be an Locator instance');
    }

    expect($this->value->getAttribute('id'))->toBe($id);

    return $this;
});

expect()->extend('toHaveClass', function (string $id): Expectation {

    /** @var ExpectationMixin<Locator> $this */
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be an Locator instance');
    }

    expect($this->value->getAttribute('class'))->toBe($id);

    return $this;
});

expect()->extend('toHaveRole', function (string $role): Expectation {
    /** @var ExpectationMixin<Locator> $this */
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be an Locator instance');
    }

    expect($this->value->getByRole($role))->not->toBeNull();

    return $this;
});

expect()->intercept(
    'toBeEmpty',
    Locator::class,
    function (): ExpectationMixin {
        /** @var ExpectationMixin<Locator> $this */
        expect($this->value->textContent())->toBe('');

        return $this;
    }
);

expect()->extend('toHaveValue', function (string $id): Expectation {
    /** @var ExpectationMixin<Locator> $this */
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be an Locator instance');
    }

    expect($this->value->inputValue())->toBe($id);

    return $this;
});

expect()->extend('toMatchScreenshot', function (bool $showDiff = false) {
    /** @var ExpectationMixin<Page> $this */
    if (! $this->value instanceof Page) {
        throw new InvalidArgumentException('Expected value to be an Page instance');
    }

    $this->value->toMatchScreenshot($showDiff);

    return $this;
});
