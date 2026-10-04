<?php

declare(strict_types=1);

use Juaniquillo\SlateBackendComponents\SlateBackendComponent;
use Juaniquillo\SlateBackendComponents\SlateComponentEnum;
use Juaniquillo\SlateBackendComponents\Utils\SlateUITableUtil;

it('keeps scalar attributes on the conforming channel', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::BUTTON))
        ->setAttribute('id', 'save-btn')
        ->setAttribute('tabindex', 1);

    expect($component->getAttribute('id'))->toBe('save-btn')
        ->and($component->getAttribute('tabindex'))->toBe(1)
        ->and($component->getAttributes())->toBe(['id' => 'save-btn', 'tabindex' => 1])
        ->and($component->getProps())->toBe([]);
});

it('keeps rich values out of the scalar read path', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::BUTTON))
        ->setProp('loading', true);

    expect($component->getProp('loading'))->toBeTrue()
        ->and($component->getAttribute('loading'))->toBeNull()
        ->and($component->getProps())->toBe(['loading' => true]);
});

it('leaves props out of the exported attributes', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::BUTTON))
        ->setAttribute('id', 'save-btn')
        ->setProp('loading', true);

    expect($component->toArray()['attributes'])->toBe(['id' => 'save-btn'])
        ->and($component->getProps())->toBe(['loading' => true]);
});

it('merges attributes and props in the attribute bag with props winning', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::BUTTON))
        ->setAttribute('id', 'save-btn')
        ->setProp('loading', true);

    expect($component->getAttributeBag()->getAttributesAndProps())
        ->toBe(['id' => 'save-btn', 'loading' => true]);
});

it('renders boolean props', function () {
    $html = (new SlateBackendComponent(SlateComponentEnum::BUTTON))
        ->setContent('Save')
        ->setProp('loading', true)
        ->toHtml();

    expect($html)->toContain('aria-busy="true"');
});

it('holds array and object props outside the export', function () {
    $config = new stdClass;

    $component = (new SlateBackendComponent(SlateComponentEnum::TABLE))
        ->setProp('rows', ['Alice'])
        ->setProp('config', $config);

    expect($component->getProp('rows'))->toBe(['Alice'])
        ->and($component->getProp('config'))->toBe($config)
        ->and($component->toArray()['attributes'])->toBe([]);
});

it('accepts multiple props at once', function () {
    $config = new stdClass;

    $component = (new SlateBackendComponent(SlateComponentEnum::TABLE))
        ->setProps(['loading' => true, 'rows' => ['Alice'], 'config' => $config]);

    expect($component->getProps())->toBe(['loading' => true, 'rows' => ['Alice'], 'config' => $config])
        ->and($component->getAttributes())->toBe([]);
});

it('overwrites props per key', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::TABLE))
        ->setProps(['loading' => true, 'rounded' => 'lg'])
        ->setProps(['loading' => false]);

    expect($component->getProps())->toBe(['loading' => false, 'rounded' => 'lg']);
});

it('routes scalar and rich table attributes to their channel', function () {
    $component = SlateUITableUtil::make(head: ['Name'], body: [['Alice']])
        ->setTableAttributes(['id' => 'orders', 'loading' => true])
        ->getComponent();

    expect($component->getAttribute('id'))->toBe('orders')
        ->and($component->getAttribute('loading'))->toBeNull()
        ->and($component->getProp('loading'))->toBeTrue();
});
