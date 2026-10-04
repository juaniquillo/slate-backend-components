<?php

declare(strict_types=1);

use Juaniquillo\SlateBackendComponents\SlateBackendComponent;
use Juaniquillo\SlateBackendComponents\SlateComponentEnum;
use Juaniquillo\SlateBackendComponents\Utils\SlateTabsUtil;

it('builds tabs triggers and panels from a labels and bodies array', function () {
    $component = SlateTabsUtil::make(
        tabs: [
            'overview' => ['label' => 'Overview', 'content' => 'Overview body'],
            'settings' => ['label' => 'Settings', 'content' => 'Settings body'],
        ],
        defaultValue: 'overview',
    )->getComponent();

    expect($component->getName())->toBe('tabs')
        ->and($component->getAttribute('defaultValue'))->toBe('overview');

    $contents = $component->getContents();

    expect($contents)->toHaveCount(3)
        ->and($contents[0]->getName())->toBe('tabs-list');

    $triggers = $contents[0]->getContents();

    expect($triggers)->toHaveCount(2)
        ->and($triggers[0])->toBeInstanceOf(SlateBackendComponent::class)
        ->and($triggers[0]->getName())->toBe('tabs-trigger')
        ->and($triggers[0]->getAttribute('value'))->toBe('overview')
        ->and($triggers[0]->getContents())->toBe(['Overview']);

    expect($contents[1]->getName())->toBe('tabs-content')
        ->and($contents[1]->getAttribute('value'))->toBe('overview')
        ->and($contents[1]->getContents())->toBe(['Overview body'])
        ->and($contents[2]->getAttribute('value'))->toBe('settings');
});

it('passes orientation to the root', function () {
    $component = SlateTabsUtil::make(
        tabs: ['overview' => ['label' => 'Overview', 'content' => 'Body']],
        orientation: 'vertical',
    )->getComponent();

    expect($component->getAttribute('orientation'))->toBe('vertical');
});

it('accepts component instances as labels and bodies', function () {
    $badge = (new SlateBackendComponent(SlateComponentEnum::BADGE))->setContent('New');

    $component = SlateTabsUtil::make(
        tabs: ['overview' => ['label' => $badge, 'content' => $badge]],
    )->getComponent();

    $triggers = $component->getContents()[0]->getContents();

    expect($triggers[0]->getContents())->toBe([$badge])
        ->and($component->getContents()[1]->getContents())->toBe([$badge]);
});

it('renders the tabs to html', function () {
    $component = SlateTabsUtil::make(
        tabs: [
            'overview' => ['label' => 'Overview', 'content' => 'Overview body'],
            'settings' => ['label' => 'Settings', 'content' => 'Settings body'],
        ],
        defaultValue: 'overview',
    )->getComponent();

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('Overview')
        ->assertSee('Overview body')
        ->assertSee('Settings')
        ->assertSee('data-slot="tabs-trigger"', false)
        ->assertSee('role="tab"', false);
});
