<?php

declare(strict_types=1);

use Juaniquillo\BackendComponents\Contracts\ContentsComponent;
use Juaniquillo\BackendComponents\Themes\DefaultThemeManager;
use Juaniquillo\SlateBackendComponents\SlateBackendComponent;
use Juaniquillo\SlateBackendComponents\SlateBackendComponentsServiceProvider;
use Juaniquillo\SlateBackendComponents\SlateComponentEnum;

it('boots the service provider', function () {
    expect(app()->providerIsLoaded(
        SlateBackendComponentsServiceProvider::class
    ))->toBeTrue();
});

it('resolves a component name from the enum', function () {
    $component = new SlateBackendComponent(SlateComponentEnum::CARD);

    expect($component->getName())->toBe('card');
});

it('resolves hyphenated component names from the enum', function () {
    $component = new SlateBackendComponent(SlateComponentEnum::CARD_HEADER);

    expect($component->getName())->toBe('card-header');
});

it('uses the slate view namespace for the component path', function () {
    $component = new SlateBackendComponent(SlateComponentEnum::CARD);

    expect($component->getContext())->toBe('slate::')
        ->and($component->getComponentPath())->toBe('slate::.card');
});

it('uses the slate namespace for hyphenated enum values', function () {
    $component = new SlateBackendComponent(SlateComponentEnum::TABLE_ROW);

    expect($component->getComponentPath())->toBe('slate::.table-row');
});

it('drops the slate namespace for local resolution', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::BUTTON))->useLocal();

    expect($component->getNamespace())->toBeNull()
        ->and($component->getComponentPath())->toBe('button');
});

it('appends a custom path to the component path', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::CARD))->setPath('pro');

    expect($component->getPathOnly())->toBe('pro')
        ->and($component->getComponentPath())->toBe('slate::pro.card');
});

it('keeps the slate context regardless of the namespace', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::CARD))->setNamespace('other');

    expect($component->getContext())->toBe('slate::')
        ->and($component->getComponentPath())->toBe('slate::.card');
});

it('accepts attributes', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::BUTTON))
        ->setAttribute('id', 'save-btn');

    expect($component->getAttribute('id'))->toBe('save-btn')
        ->and($component->getAttributes())->toBe(['id' => 'save-btn']);
});

it('accepts multiple attributes at once', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::BUTTON))
        ->setAttributes(['id' => 'save-btn', 'variant' => 'outline']);

    expect($component->getAttributes())->toBe(['id' => 'save-btn', 'variant' => 'outline']);
});

it('returns null for a missing attribute', function () {
    expect((new SlateBackendComponent(SlateComponentEnum::BUTTON))->getAttribute('missing'))->toBeNull();
});

it('accepts content', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::BUTTON))
        ->setContent('Click me');

    expect($component->processContent())->toBeInstanceOf(ContentsComponent::class)
        ->and($component->processContent()->toArray())->toBe(['Click me']);
});

it('accepts keyed content', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::BUTTON))
        ->setContent('Hello', 'greeting');

    expect($component->getContent('greeting'))->toBe('Hello')
        ->and($component->processContent()->toArray())->toBe(['greeting' => 'Hello']);
});

it('accepts a batch of content', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::BUTTON))
        ->setContents(['Hello', 'World']);

    expect($component->getContents())->toBe(['Hello', 'World'])
        ->and($component->processContent()->toArray())->toBe(['Hello', 'World']);
});

it('nests components via contents', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::CARD))
        ->setContents([
            (new SlateBackendComponent(SlateComponentEnum::CARD_HEADER))->setContent('Title'),
            (new SlateBackendComponent(SlateComponentEnum::CARD_FOOTER))->setContent('Footer'),
        ]);

    expect($component->getContents())->toHaveCount(2);
});

it('serializes the component to an array', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::CARD))
        ->setAttribute('id', 'my-card')
        ->setContent('Hello');

    $array = $component->toArray();

    expect($array)
        ->toHaveKey('name', 'card')
        ->toHaveKey('attributes', ['id' => 'my-card'])
        ->toHaveKey('content', ['Hello'])
        ->toHaveKey('path', 'slate::.card')
        ->toHaveKey('theme.manager', DefaultThemeManager::class)
        ->toHaveKey('theme.themes', $component->getThemes())
        ->toHaveKey('theme.path', $component->getThemeManager()->getDefaultPath())
        ->toHaveKey('theme.realPath', $component->getThemeManager()->getThemePath());
});

it('serializes to json when cast to string', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::CARD))
        ->setContent('Hello');

    expect((string) $component)->toBe(\json_encode($component->toArray()));
});

it('renders the button component to html', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::BUTTON))
        ->setContent('Click me')
        ->setAttribute('id', 'save-btn');

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('<button', false)
        ->assertSee('data-slot="button"', false)
        ->assertSee('Click me')
        ->assertSee('id="save-btn"', false);
});

it('renders the button variant attribute', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::BUTTON))
        ->setContent('Cancel')
        ->setAttribute('variant', 'outline');

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('Cancel');
});

it('renders any slate component to html', function () {
    $component = (new SlateBackendComponent(SlateComponentEnum::CARD))
        ->setContent('Hello');

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('Hello')
        ->assertDontSee('data-slot="button"', false);
});
