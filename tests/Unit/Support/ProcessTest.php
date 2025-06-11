<?php

declare(strict_types=1);

use Pest\Browser\Support\Process;

it('may start a process', function (): void {
    $process = Process::create(
        __DIR__,
        'php -S localhost:8000 -t .',
        'localhost',
        'Development Server',
        9999,
    );

    expect((fn (): bool => $process->isRunning())->call($process))->toBeFalse();

    $process->start();

    expect((fn (): bool => $process->isRunning())->call($process))->toBeTrue();

    $process->stop();
});
