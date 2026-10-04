<?php

declare(strict_types=1);

namespace Juaniquillo\SlateBackendComponents\Utils;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\BackendComponents\Themes\LocalThemeManager;
use Juaniquillo\SlateBackendComponents\SlateBackendComponent;
use Juaniquillo\SlateBackendComponents\SlateComponentEnum;

/**
 * Builds a complete Slate tabs component tree from a tabs array.
 *
 * Tab keys become the shared trigger/content values that the Alpine
 * state tracks, so panels stay wired without hand-written value props.
 */
final readonly class SlateTabsUtil
{
    /**
     * @param  array<string|int, array{label: string|BackendComponent, content: string|BackendComponent}>  $tabs
     */
    public function __construct(
        private array $tabs,
        private string|int|null $defaultValue = null,
        private string $orientation = 'horizontal',
        private ThemeManager $themeManager = new LocalThemeManager,
    ) {}

    /**
     * @param  array<string|int, array{label: string|BackendComponent, content: string|BackendComponent}>  $tabs
     */
    public static function make(array $tabs, string|int|null $defaultValue = null, string $orientation = 'horizontal', ThemeManager $themeManager = new LocalThemeManager): static
    {
        return new self($tabs, $defaultValue, $orientation, $themeManager);
    }

    public function getComponent(): BackendComponent
    {
        $triggers = [];
        $panels = [];

        foreach ($this->tabs as $value => $tab) {
            $triggers[] = (new SlateBackendComponent(SlateComponentEnum::TABS_TRIGGER, $this->themeManager))
                ->setAttribute('value', $value)
                ->setContent($tab['label']);

            $panels[] = (new SlateBackendComponent(SlateComponentEnum::TABS_CONTENT, $this->themeManager))
                ->setAttribute('value', $value)
                ->setContent($tab['content']);
        }

        $list = (new SlateBackendComponent(SlateComponentEnum::TABS_LIST, $this->themeManager))
            ->setContents($triggers);

        $component = (new SlateBackendComponent(SlateComponentEnum::TABS, $this->themeManager))
            ->setAttribute('orientation', $this->orientation)
            ->setContents([$list, ...$panels]);

        if ($this->defaultValue !== null) {
            $component->setAttribute('defaultValue', $this->defaultValue);
        }

        return $component;
    }
}
