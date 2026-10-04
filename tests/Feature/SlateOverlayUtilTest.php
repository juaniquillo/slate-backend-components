<?php

declare(strict_types=1);

use Juaniquillo\SlateBackendComponents\SlateBackendComponent;
use Juaniquillo\SlateBackendComponents\SlateComponentEnum;
use Juaniquillo\SlateBackendComponents\Utils\SlateOverlayUtil;

it('rejects non-overlay roots', function () {
    SlateOverlayUtil::make(SlateComponentEnum::BUTTON, 'Body');
})->throws(InvalidArgumentException::class);

it('builds a dialog tree from trigger, title, and body', function () {
    $component = SlateOverlayUtil::make(
        root: SlateComponentEnum::DIALOG,
        content: 'Dialog body',
        trigger: 'Open dialog',
        title: 'Edit profile',
        description: 'Make changes below.',
    )->getComponent();

    expect($component->getName())->toBe('dialog');

    $contents = $component->getContents();

    expect($contents)->toHaveCount(2)
        ->and($contents[0])->toBeInstanceOf(SlateBackendComponent::class)
        ->and($contents[0]->getName())->toBe('dialog-trigger')
        ->and($contents[1]->getName())->toBe('dialog-content');

    $contentParts = $contents[1]->getContents();

    expect($contentParts)->toHaveCount(2)
        ->and($contentParts[0]->getName())->toBe('dialog-header')
        ->and($contentParts[1])->toBe('Dialog body');

    $headerParts = $contentParts[0]->getContents();

    expect($headerParts)->toHaveCount(2)
        ->and($headerParts[0]->getName())->toBe('dialog-title')
        ->and($headerParts[1]->getName())->toBe('dialog-description');
});

it('omits the trigger when none is given', function () {
    $component = SlateOverlayUtil::make(
        root: SlateComponentEnum::SHEET,
        content: 'Sheet body',
    )->getComponent();

    $contents = $component->getContents();

    expect($contents)->toHaveCount(1)
        ->and($contents[0]->getName())->toBe('sheet-content')
        ->and($contents[0]->getContents())->toBe(['Sheet body']);
});

it('wraps the footer in the root footer part', function () {
    $component = SlateOverlayUtil::make(
        root: SlateComponentEnum::DRAWER,
        content: 'Drawer body',
        footer: 'Drawer footer',
    )->getComponent();

    $contentParts = $component->getContents()[0]->getContents();

    expect($contentParts)->toHaveCount(2)
        ->and($contentParts[1]->getName())->toBe('drawer-footer');
});

it('accepts component instances for every slot', function () {
    $button = (new SlateBackendComponent(SlateComponentEnum::BUTTON))->setContent('Open');

    $component = SlateOverlayUtil::make(
        root: SlateComponentEnum::DIALOG,
        content: $button,
        trigger: $button,
        title: $button,
        footer: $button,
    )->getComponent();

    $triggerContents = $component->getContents()[0]->getContents();
    $contentParts = $component->getContents()[1]->getContents();

    expect($triggerContents)->toBe([$button])
        ->and($contentParts[1])->toBe($button);
});

it('builds an alert dialog with action buttons in the footer', function () {
    $action = (new SlateBackendComponent(SlateComponentEnum::BUTTON))->setContent('Delete');
    $cancel = (new SlateBackendComponent(SlateComponentEnum::BUTTON))->setContent('Cancel');

    $component = SlateOverlayUtil::make(
        root: SlateComponentEnum::ALERT_DIALOG,
        content: 'This action cannot be undone.',
        trigger: 'Delete account',
        title: 'Are you sure?',
        footer: [$action, $cancel],
    )->getComponent();

    expect($component->getName())->toBe('alert-dialog');

    $contentParts = $component->getContents()[1]->getContents();

    expect($contentParts[2]->getName())->toBe('alert-dialog-footer')
        ->and($contentParts[2]->getContents())->toBe([$action, $cancel]);
});

it('renders the dialog to html', function () {
    $component = SlateOverlayUtil::make(
        root: SlateComponentEnum::DIALOG,
        content: 'Dialog body',
        trigger: 'Open dialog',
        title: 'Edit profile',
    )->getComponent();

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('Open dialog')
        ->assertSee('Edit profile')
        ->assertSee('Dialog body')
        ->assertSee('data-slot="dialog-content"', false)
        ->assertSee('data-slot="dialog-close"', false);
});

it('hides the close button when requested', function () {
    $component = SlateOverlayUtil::make(
        root: SlateComponentEnum::DIALOG,
        content: 'Dialog body',
    )->setShowCloseButton(false)->getComponent();

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('Dialog body')
        ->assertDontSee('data-slot="dialog-close"', false);
});

it('accepts a list of blocks as content', function () {
    $component = SlateOverlayUtil::make(
        root: SlateComponentEnum::DIALOG,
        content: ['First paragraph', 'Second paragraph'],
    )->getComponent();

    $contentParts = $component->getContents()[0]->getContents();

    expect($contentParts)->toBe(['First paragraph', 'Second paragraph']);

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('First paragraph')
        ->assertSee('Second paragraph');
});

it('routes rich trigger attributes to props', function () {
    $component = SlateOverlayUtil::make(
        root: SlateComponentEnum::DIALOG,
        content: 'Body',
        trigger: 'Open',
    )
        ->setTriggerAttributes(['id' => 'open-btn', 'disabled' => true])
        ->getComponent();

    $trigger = $component->getContents()[0];

    expect($trigger->getAttribute('id'))->toBe('open-btn')
        ->and($trigger->getAttribute('disabled'))->toBeNull()
        ->and($trigger->getProp('disabled'))->toBeTrue();
});
