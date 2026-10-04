<?php

declare(strict_types=1);

namespace Juaniquillo\SlateBackendComponents\Utils;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\BackendComponents\Themes\LocalThemeManager;
use Juaniquillo\SlateBackendComponents\SlateBackendComponent;
use Juaniquillo\SlateBackendComponents\SlateComponentEnum;

/**
 * Builds a complete Slate accordion component tree from an items array.
 *
 * Item keys become the accordion-item values that the Alpine state tracks,
 * so triggers and panels stay wired without hand-written value props.
 */
final readonly class SlateAccordionUtil
{
    /**
     * @param  array<string|int, array{title: string|BackendComponent, content: string|BackendComponent}>  $items
     * @param  string|array<string|int, string>|null  $defaultValue
     */
    public function __construct(
        private array $items,
        private string $type = 'single',
        private string|array|null $defaultValue = null,
        private ThemeManager $themeManager = new LocalThemeManager,
    ) {}

    /**
     * @param  array<string|int, array{title: string|BackendComponent, content: string|BackendComponent}>  $items
     * @param  string|array<string|int, string>|null  $defaultValue
     */
    public static function make(array $items, string $type = 'single', string|array|null $defaultValue = null, ThemeManager $themeManager = new LocalThemeManager): static
    {
        return new self($items, $type, $defaultValue, $themeManager);
    }

    public function getComponent(): BackendComponent
    {
        $items = [];

        foreach ($this->items as $value => $item) {
            $items[] = $this->item($value, $item['title'], $item['content']);
        }

        $component = (new SlateBackendComponent(SlateComponentEnum::ACCORDION, $this->themeManager))
            ->setAttribute('type', $this->type)
            ->setContents($items);

        if (is_string($this->defaultValue)) {
            $component->setAttribute('defaultValue', $this->defaultValue);
        } elseif ($this->defaultValue !== null) {
            $component->setProp('defaultValue', $this->defaultValue);
        }

        return $component;
    }

    private function item(string|int $value, string|BackendComponent $title, string|BackendComponent $content): SlateBackendComponent
    {
        return (new SlateBackendComponent(SlateComponentEnum::ACCORDION_ITEM, $this->themeManager))
            ->setAttribute('value', $value)
            ->setContents([
                (new SlateBackendComponent(SlateComponentEnum::ACCORDION_TRIGGER, $this->themeManager))
                    ->setContent($title),
                (new SlateBackendComponent(SlateComponentEnum::ACCORDION_CONTENT, $this->themeManager))
                    ->setContent($content),
            ]);
    }
}
