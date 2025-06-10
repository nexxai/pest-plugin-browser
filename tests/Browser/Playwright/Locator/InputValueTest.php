<?php

declare(strict_types=1);

it('can get input value', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    $input = $page->getByTestId('prefilled-input');

    expect($input->inputValue())->not()->toBe('');
});

it('can get specific input values', function (): void {
    $page = $this->page()->goto('/test/element-tests');
    $input = $page->getByLabel('Username');

    expect($input->inputValue())->toBe('johndoe');
});
