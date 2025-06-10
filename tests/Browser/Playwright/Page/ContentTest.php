<?php

declare(strict_types=1);

it('returns the full HTML content of the frame', function (): void {
    $page = $this->page('/test/frame-tests');
    $content = $page->content();

    expect($content)->toBeString();
    expect($content)->toContain('<html');
    expect($content)->toContain('</html>');
    expect($content)->toContain('Frame Testing Page');
});
