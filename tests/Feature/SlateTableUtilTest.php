<?php

declare(strict_types=1);

use Juaniquillo\BackendComponents\Utils\CellBag;
use Juaniquillo\SlateBackendComponents\SlateBackendComponent;
use Juaniquillo\SlateBackendComponents\SlateComponentEnum;
use Juaniquillo\SlateBackendComponents\Utils\SlateUITableUtil;

it('builds a table component tree from head and body arrays', function () {
    $component = SlateUITableUtil::make(
        head: ['Customer', 'Status'],
        body: [['Alice', 'Paid']],
    )->getComponent();

    expect($component->getName())->toBe('table');

    $contents = $component->getContents();

    expect($contents)->toHaveCount(2)
        ->and($contents[0])->toBeInstanceOf(SlateBackendComponent::class)
        ->and($contents[0]->getName())->toBe('table-header')
        ->and($contents[1]->getName())->toBe('table-body');
});

it('wraps header columns in a row of head cells', function () {
    $component = SlateUITableUtil::make(
        head: ['Customer', 'Status'],
        body: [],
    )->getComponent();

    $header = $component->getContents()[0];
    $row = $header->getContents()[0];

    expect($row->getName())->toBe('table-row');

    $cells = $row->getContents();

    expect($cells)->toHaveCount(2)
        ->and($cells[0]->getName())->toBe('table-head')
        ->and($cells[0]->getContents())->toBe(['Customer']);
});

it('builds body rows of cells', function () {
    $component = SlateUITableUtil::make(
        head: [],
        body: [['Alice', 'Paid'], ['Bob', 'Pending']],
    )->getComponent();

    $contents = $component->getContents();

    expect($contents)->toHaveCount(1);

    $rows = $contents[0]->getContents();

    expect($rows)->toHaveCount(2)
        ->and($rows[0]->getName())->toBe('table-row');

    $cells = $rows[0]->getContents();

    expect($cells)->toHaveCount(2)
        ->and($cells[0]->getName())->toBe('table-cell')
        ->and($cells[0]->getContents())->toBe(['Alice']);
});

it('accepts component instances as cells', function () {
    $badge = (new SlateBackendComponent(SlateComponentEnum::BADGE))->setContent('Paid');

    $component = SlateUITableUtil::make(
        head: ['Status'],
        body: [[$badge]],
    )->getComponent();

    $rows = $component->getContents()[1]->getContents();
    $cells = $rows[0]->getContents();

    expect($cells[0]->getContents())->toBe([$badge]);
});

it('accepts cell bags with per-cell attributes', function () {
    $component = SlateUITableUtil::make(
        head: ['Status'],
        body: [[new CellBag(
            content: 'Paid',
            attributes: ['variant' => 'strong'],
        )]],
    )->getComponent();

    $rows = $component->getContents()[1]->getContents();
    $cells = $rows[0]->getContents();

    expect($cells[0]->getContents())->toBe(['Paid'])
        ->and($cells[0]->getAttribute('variant'))->toBe('strong');
});

it('renders the table to html', function () {
    $component = SlateUITableUtil::make(
        head: ['Customer'],
        body: [['Alice']],
    )->getComponent();

    $this->blade('{{ $component }}', ['component' => $component])
        ->assertSee('Customer')
        ->assertSee('Alice')
        ->assertSee('<table', false);
});
