<?php

declare(strict_types=1);

use Pest\Browser\Playwright\Element;

it('returns empty array when no elements match', function (): void {
    $page = page('/test/frame-tests');
    $elements = $page->querySelectorAll('.non-existent-class');

    expect($elements)->toBeArray();
    expect($elements)->toHaveCount(0);
});

it('returns single element in array when one element matches', function (): void {
    $page = page('/test/frame-tests');
    $elements = $page->querySelectorAll('#unique-element');

    expect($elements)->toBeArray();
    expect($elements)->toHaveCount(1);
    expect($elements[0])->toBeInstanceOf(Element::class);
});

it('returns multiple elements when multiple match', function (): void {
    $page = page('/test/frame-tests');
    $elements = $page->querySelectorAll('.test-item');

    expect($elements)->toBeArray();
    expect(count($elements))->toBeGreaterThan(1);

    foreach ($elements as $element) {
        expect($element)->toBeInstanceOf(Element::class);
    }
});

it('can find all input elements', function (): void {
    $page = page('/test/frame-tests');
    $inputs = $page->querySelectorAll('input');

    expect($inputs)->toBeArray();
    expect(count($inputs))->toBeGreaterThan(0);

    foreach ($inputs as $input) {
        expect($input)->toBeInstanceOf(Element::class);
    }
});

it('can find all elements by tag name', function (): void {
    $page = page('/test/frame-tests');
    $buttons = $page->querySelectorAll('button');

    expect($buttons)->toBeArray();
    expect(count($buttons))->toBeGreaterThan(0);
});
