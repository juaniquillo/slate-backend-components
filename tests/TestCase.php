<?php

declare(strict_types=1);

namespace Juaniquillo\SlateBackendComponents\Tests;

use Electrik\Slate\SlateServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;
use Juaniquillo\BackendComponents\BackendComponentsServiceProvider;
use Juaniquillo\SlateBackendComponents\SlateBackendComponentsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        View::share('errors', new ViewErrorBag);
    }

    protected function getPackageProviders($app): array
    {
        return [
            BackendComponentsServiceProvider::class,
            SlateServiceProvider::class,
            SlateBackendComponentsServiceProvider::class,
        ];
    }
}
