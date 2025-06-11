<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Locator;
use Pest\Browser\Playwright\Page;
use Pest\Expectation;
use Pest\Mixins\Expectation as ExpectationMixin;

// todo: move this to Pest core
expect()->extend('toHaveTitle', function (string $title): Expectation {
    if (! $this->value instanceof Page) {
        throw new InvalidArgumentException('Expected value to be an Page instance');
    }

    expect($this->value->title())->toBe($title);

    return $this;
});

expect()->extend('toHaveText', function (string $content): Expectation {
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be an Locator instance');
    }

    expect($this->value->textContent())->toContain($content);

    return $this;
});

expect()->extend('toBeChecked', function (): Expectation {
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be a Locator instance');
    }

    expect($this->value->isChecked())->toBeTrue();

    return $this;
});

expect()->extend('toBeVisible', function (): Expectation {
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be a Locator instance');
    }

    expect($this->value->isVisible())->toBeTrue();

    return $this;
});

expect()->extend('toBeEnabled', function (): Expectation {
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be a Locator instance');
    }

    expect($this->value->isEnabled())->toBeTrue();

    return $this;
});

expect()->extend('toBeDisabled', function (): Expectation {

    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be a Locator instance');
    }

    expect($this->value->isDisabled())->toBeTrue();

    return $this;
});

expect()->extend('toBeEditable', function (): Expectation {
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be a Locator instance');
    }

    expect($this->value->isEditable())->toBeTrue();

    return $this;
});

expect()->extend('toBeHidden', function (): Expectation {
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be a Locator instance');
    }

    expect($this->value->isHidden())->toBeTrue();

    return $this;
});

expect()->extend('toHaveId', function (string $id): Expectation {

    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be an Locator instance');
    }

    expect($this->value->getAttribute('id'))->toBe($id);

    return $this;
});

expect()->extend('toHaveClass', function (string $id): Expectation {

    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be an Locator instance');
    }

    expect($this->value->getAttribute('class'))->toBe($id);

    return $this;
});

expect()->extend('toHaveRole', function (string $role): Expectation {
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
        expect($this->value->textContent())->toBe('');

        return $this;
    }
);

expect()->extend('toHaveValue', function (string $id): Expectation {
    if (! $this->value instanceof Locator) {
        throw new InvalidArgumentException('Expected value to be an Locator instance');
    }

    expect($this->value->inputValue())->toBe($id);

    return $this;
});
// todo: move this to Pest core end
