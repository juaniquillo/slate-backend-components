<?php

declare(strict_types=1);

use Electrik\Slate\SlateServiceProvider;
use Juaniquillo\SlateBackendComponents\SlateComponentEnum;

it('covers every slate blade component', function () {
    $componentsPath = dirname(
        (string) (new ReflectionClass(SlateServiceProvider::class))->getFileName()
    ).'/../resources/views/components/*.blade.php';

    $bladeFiles = glob($componentsPath) ?: [];

    $names = array_map(
        static fn (string $path): string => basename($path, '.blade.php'),
        $bladeFiles
    );

    expect($names)->not->toBeEmpty();

    $cases = array_map(
        static fn (SlateComponentEnum $case): string => $case->value,
        SlateComponentEnum::cases()
    );

    foreach ($names as $name) {
        expect($cases)->toContain($name);
    }

    expect(SlateComponentEnum::cases())->toHaveCount(count($names));
});

it('resolves spot-checked components to views', function () {
    foreach (['button', 'card-header', 'table-row', 'dialog-content'] as $name) {
        expect(view()->exists('slate::components.'.$name))->toBeTrue();
    }
});
