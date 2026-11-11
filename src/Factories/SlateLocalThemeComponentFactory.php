<?php

declare(strict_types=1);

namespace Juaniquillo\SlateBackendComponents\Factories;

use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;
use Juaniquillo\BackendComponents\Contracts\StaticFactory;
use Juaniquillo\BackendComponents\Themes\LocalThemeManager;
use Juaniquillo\BaseBackendComponent\Contracts\CompoundComponent;
use Juaniquillo\SlateBackendComponents\SlateBackendComponent;

class SlateLocalThemeComponentFactory implements StaticFactory
{
    public static function make(string|BackedEnum $name): Htmlable|CompoundComponent
    {
        return new SlateBackendComponent($name, new LocalThemeManager);
    }
}
