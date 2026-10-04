<?php

declare(strict_types=1);

use Juaniquillo\SlateBackendComponents\SlateBackendComponent;
use Juaniquillo\SlateBackendComponents\SlateComponentEnum;
use Juaniquillo\SlateBackendComponents\Utils\SlateAccordionUtil;

it('builds accordion items from a titles and bodies array', function () {
    $component = SlateAccordionUtil::make(
        items: [
            'item-1' => ['title' => 'First', 'content' => 'First body'],
            'item-2' => ['title' => 'Second', 'content' => 'Second body'],
        ],
    )->getComponent();

    expect($component->getName())->toBe('accordion');

    $items = $component->getContents();

    expect($items)->toHaveCount(2)
        ->and($items[0])->toBeInstanceOf(SlateBackendComponent::class)
        ->and($items[0]->getName())->toBe('accordion-item')
        ->and($items[0]->getAttribute('value'))->toBe('item-1');

    $parts = $items[0]->getContents();

    expect($parts)->toHaveCount(2)
        ->and($parts[0]->getName())->toBe('accordion-trigger')
        ->and($parts[0]->getContents())->toBe(['First'])
        ->and($parts[1]->getName())->toBe('accordion-content')
        ->and($parts[1]->getContents())->toBe(['First body']);
});

it('passes type and default value to the root', function () {
    $component = SlateAccordionUtil::make(
        items: ['item-1' => ['title' => 'First', 'content' => 'Body']],
        type: 'multiple',
        defaultValue: ['item-1'],
    )->getComponent();

    expect($component->getAttribute('type'))->toBe('multiple')
        ->and($component->getAttribute('defaultValue'))->toBeNull()
        ->and($component->getProp('defaultValue'))->toBe(['item-1']);
});

it('passes a string default value as an attribute', function () {
    $component = SlateAccordionUtil::make(
        items: ['item-1' => ['title' => 'First', 'content' => 'Body']],
        defaultValue: 'item-1',
    )->getComponent();

    expect($component->getAttribute('defaultValue'))->toBe('item-1');
});

it('accepts component instances as titles and bodies', function () {
    $badge = (new SlateBackendComponent(SlateComponentEnum::BADGE))->setContent('New');

    $component = SlateAccordionUtil::make(
        items: ['item-1' => ['title' => $badge, 'content' => $badge]],
    )->getComponent();

    $parts = $component->getContents()[0]->getContents();

    expect($parts[0]->getContents())->toBe([$badge])
        ->and($parts[1]->getContents())->toBe([$badge]);
});

it('renders the accordion to html', function () {
    $component = SlateAccordionUtil::make(
        items: [
            'item-1' => ['title' => 'First', 'content' => 'First body'],
            'item-2' => ['title' => 'Second', 'content' => 'Second body'],
        ],
        defaultValue: 'item-1',
    )->getComponent();

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('First')
        ->assertSee('First body')
        ->assertSee('Second')
        ->assertSee('data-slot="accordion-item"', false);
});
