<?php declare(strict_types=1);

namespace Pest\Browser\Support;

final class WithinContext
{
    private static ?string $currentScope = null;

    public static function setScope(?string $scope): void
    {
        self::$currentScope = $scope;
    }

    public static function getScope(): ?string
    {
        return self::$currentScope;
    }

    public static function clearScope(): void
    {
        self::$currentScope = null;
    }
}