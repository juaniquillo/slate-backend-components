<?php

declare(strict_types=1);

namespace Juaniquillo\SlateBackendComponents\Builders;

use BackedEnum;
use Illuminate\Contracts\Support\Htmlable;
use Juaniquillo\BackendComponents\Contracts\CompoundComponent;
use Juaniquillo\BackendComponents\Contracts\StaticBuilder;
use Juaniquillo\SlateBackendComponents\SlateBackendComponent;

class SlateComponentBuilder implements StaticBuilder
{
    public static function make(string|BackedEnum $name): Htmlable|CompoundComponent
    {
        return new SlateBackendComponent($name);
    }
}
