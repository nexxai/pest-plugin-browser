<?php

declare(strict_types=1);

it('can get inner HTML', function (): void {
    $page = page('/test/element-tests');
    $element = $page->getByTestId('profile-section');

    expect($element->innerHTML())->toContain('<');
});

it('can get inner HTML of elements with specific content', function (): void {
    $page = page('/test/element-tests');
    $element = $page->getByTestId('profile-section');

    $html = $element->innerHTML();
    expect($html)->toBeString();
    expect($html)->toContain('This section has a data-testid attribute');
});
