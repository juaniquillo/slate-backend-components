<?php

declare(strict_types=1);

namespace Juaniquillo\SlateBackendComponents\Utils;

use InvalidArgumentException;
use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeManager;
use Juaniquillo\BackendComponents\Themes\LocalThemeManager;
use Juaniquillo\SlateBackendComponents\SlateBackendComponent;
use Juaniquillo\SlateBackendComponents\SlateComponentEnum;

/**
 * Builds a complete Slate overlay component tree (dialog, alert-dialog,
 * sheet, or drawer) from content, trigger, title, description, and footer.
 *
 * Parts resolve from the root enum value (e.g. DIALOG + trigger resolves
 * the DIALOG_TRIGGER case), so unknown roots fail loudly at build time.
 */
final class SlateOverlayUtil
{
    /**
     * @var array<string, int|string|null>
     */
    private array $rootAttributes = [];

    /**
     * @var array<string, int|string|null>
     */
    private array $triggerAttributes = [];

    /**
     * @var array<string, int|string|null>
     */
    private array $contentAttributes = [];

    /**
     * @var array<string, string|array<string|int, string>>
     */
    private array $rootThemes = [];

    /**
     * @var array<string, string|array<string|int, string>>
     */
    private array $triggerThemes = [];

    /**
     * @var array<string, string|array<string|int, string>>
     */
    private array $contentThemes = [];

    private bool $showCloseButton = true;

    /**
     * @param  string|BackendComponent|array<string|int, string|BackendComponent>  $content
     * @param  string|BackendComponent|array<string|int, string|BackendComponent>|null  $trigger
     * @param  string|BackendComponent|array<string|int, string|BackendComponent>|null  $title
     * @param  string|BackendComponent|array<string|int, string|BackendComponent>|null  $description
     * @param  string|BackendComponent|array<string|int, string|BackendComponent>|null  $footer
     */
    public function __construct(
        private readonly SlateComponentEnum $root,
        private readonly string|BackendComponent|array $content,
        private readonly string|BackendComponent|array|null $trigger = null,
        private readonly string|BackendComponent|array|null $title = null,
        private readonly string|BackendComponent|array|null $description = null,
        private readonly string|BackendComponent|array|null $footer = null,
        private readonly ThemeManager $themeManager = new LocalThemeManager,
    ) {
        if (! in_array($this->root, [SlateComponentEnum::DIALOG, SlateComponentEnum::ALERT_DIALOG, SlateComponentEnum::SHEET, SlateComponentEnum::DRAWER], true)) {
            throw new InvalidArgumentException(
                'SlateOverlayUtil only supports DIALOG, ALERT_DIALOG, SHEET, and DRAWER roots.'
            );
        }
    }

    /**
     * @param  string|BackendComponent|array<string|int, string|BackendComponent>  $content
     * @param  string|BackendComponent|array<string|int, string|BackendComponent>|null  $trigger
     * @param  string|BackendComponent|array<string|int, string|BackendComponent>|null  $title
     * @param  string|BackendComponent|array<string|int, string|BackendComponent>|null  $description
     * @param  string|BackendComponent|array<string|int, string|BackendComponent>|null  $footer
     */
    public static function make(
        SlateComponentEnum $root,
        string|BackendComponent|array $content,
        string|BackendComponent|array|null $trigger = null,
        string|BackendComponent|array|null $title = null,
        string|BackendComponent|array|null $description = null,
        string|BackendComponent|array|null $footer = null,
        ThemeManager $themeManager = new LocalThemeManager,
    ): static {
        return new self($root, $content, $trigger, $title, $description, $footer, $themeManager);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function setRootAttributes(array $attributes): static
    {
        $this->rootAttributes = $attributes;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function setTriggerAttributes(array $attributes): static
    {
        $this->triggerAttributes = $attributes;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function setContentAttributes(array $attributes): static
    {
        $this->contentAttributes = $attributes;

        return $this;
    }

    /**
     * @param  array<string, string|array<string|int, string>>  $themes
     */
    public function setRootThemes(array $themes): static
    {
        $this->rootThemes = $themes;

        return $this;
    }

    /**
     * @param  array<string, string|array<string|int, string>>  $themes
     */
    public function setTriggerThemes(array $themes): static
    {
        $this->triggerThemes = $themes;

        return $this;
    }

    /**
     * @param  array<string, string|array<string|int, string>>  $themes
     */
    public function setContentThemes(array $themes): static
    {
        $this->contentThemes = $themes;

        return $this;
    }

    /**
     * Applies to dialog, sheet, and drawer content. Alert dialogs use
     * action/cancel buttons instead and ignore this setting.
     */
    public function setShowCloseButton(bool $show = true): static
    {
        $this->showCloseButton = $show;

        return $this;
    }

    public function getComponent(): BackendComponent
    {
        $contents = [];

        if ($this->trigger !== null) {
            $contents[] = $this->composeComponent(
                $this->part('trigger'),
                $this->trigger,
                $this->triggerThemes,
                $this->triggerAttributes,
            );
        }

        $contents[] = $this->content();

        return $this->composeComponent(
            $this->root,
            $contents,
            $this->rootThemes,
            $this->rootAttributes,
        );
    }

    private function content(): SlateBackendComponent
    {
        $contents = [];

        if ($this->title !== null || $this->description !== null) {
            $contents[] = $this->header();
        }

        foreach ($this->asList($this->content) as $item) {
            $contents[] = $item;
        }

        if ($this->footer !== null) {
            $contents[] = $this->composeComponent($this->part('footer'), $this->footer);
        }

        $component = $this->composeComponent(
            $this->part('content'),
            $contents,
            $this->contentThemes,
            $this->contentAttributes,
        );

        if (! $this->showCloseButton && $this->root !== SlateComponentEnum::ALERT_DIALOG) {
            $component->setProp('showCloseButton', false);
        }

        return $component;
    }

    private function header(): SlateBackendComponent
    {
        $contents = [];

        if ($this->title !== null) {
            $contents[] = $this->composeComponent($this->part('title'), $this->title);
        }

        if ($this->description !== null) {
            $contents[] = $this->composeComponent($this->part('description'), $this->description);
        }

        return $this->composeComponent($this->part('header'), $contents);
    }

    private function part(string $name): SlateComponentEnum
    {
        return SlateComponentEnum::from($this->root->value.'-'.$name);
    }

    /**
     * @param  string|BackendComponent|array<string|int, string|BackendComponent>  $slot
     * @return array<string|int, string|BackendComponent>
     */
    private function asList(string|BackendComponent|array $slot): array
    {
        return is_array($slot) ? $slot : [$slot];
    }

    /**
     * @param  int|string|BackendComponent|array<int|string, int|string|BackendComponent>  $contents
     * @param  array<string, string|array<string|int, string>>|null  $theme
     * @param  array<string, mixed>|null  $attributes
     */
    private function composeComponent(SlateComponentEnum $name, int|array|string|BackendComponent $contents, ?array $theme = null, ?array $attributes = null): SlateBackendComponent
    {
        $contents = is_array($contents) ? $contents : [$contents];

        $component = (new SlateBackendComponent($name, $this->themeManager))
            ->setContents($contents);

        if ($theme) {
            $component->setThemes($theme);
        }

        if ($attributes) {
            $this->setComponentAttributes($component, $attributes);
        }

        return $component;
    }

    /**
     * Scalar values use the conforming attribute channel, anything richer
     * (booleans, arrays, objects) goes through the mixed content channel.
     *
     * @param  array<string, mixed>  $attributes
     */
    private function setComponentAttributes(SlateBackendComponent $component, array $attributes): void
    {
        foreach ($attributes as $name => $value) {
            if (is_string($value) || is_int($value) || $value === null) {
                $component->setAttribute($name, $value);
            } else {
                $component->setProp($name, $value);
            }
        }
    }
}
