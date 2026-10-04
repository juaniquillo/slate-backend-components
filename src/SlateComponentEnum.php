<?php

declare(strict_types=1);

namespace Juaniquillo\SlateBackendComponents;

enum SlateComponentEnum: string
{
    // accordion
    case ACCORDION = 'accordion';
    case ACCORDION_CONTENT = 'accordion-content';
    case ACCORDION_ITEM = 'accordion-item';
    case ACCORDION_TRIGGER = 'accordion-trigger';

    // alert
    case ALERT = 'alert';
    case ALERT_ACTION = 'alert-action';
    case ALERT_DESCRIPTION = 'alert-description';
    case ALERT_DIALOG = 'alert-dialog';
    case ALERT_DIALOG_ACTION = 'alert-dialog-action';
    case ALERT_DIALOG_CANCEL = 'alert-dialog-cancel';
    case ALERT_DIALOG_CONTENT = 'alert-dialog-content';
    case ALERT_DIALOG_DESCRIPTION = 'alert-dialog-description';
    case ALERT_DIALOG_FOOTER = 'alert-dialog-footer';
    case ALERT_DIALOG_HEADER = 'alert-dialog-header';
    case ALERT_DIALOG_TITLE = 'alert-dialog-title';
    case ALERT_DIALOG_TRIGGER = 'alert-dialog-trigger';
    case ALERT_TITLE = 'alert-title';

    // app
    case APP_SHELL = 'app-shell';

    // aspect
    case ASPECT_RATIO = 'aspect-ratio';

    // avatar
    case AVATAR = 'avatar';
    case AVATAR_BADGE = 'avatar-badge';
    case AVATAR_FALLBACK = 'avatar-fallback';
    case AVATAR_GROUP = 'avatar-group';
    case AVATAR_GROUP_COUNT = 'avatar-group-count';
    case AVATAR_IMAGE = 'avatar-image';

    // badge
    case BADGE = 'badge';

    // breadcrumb
    case BREADCRUMB = 'breadcrumb';
    case BREADCRUMB_ELLIPSIS = 'breadcrumb-ellipsis';
    case BREADCRUMB_ITEM = 'breadcrumb-item';
    case BREADCRUMB_LINK = 'breadcrumb-link';
    case BREADCRUMB_LIST = 'breadcrumb-list';
    case BREADCRUMB_PAGE = 'breadcrumb-page';
    case BREADCRUMB_SEPARATOR = 'breadcrumb-separator';

    // button
    case BUTTON = 'button';
    case BUTTON_GROUP = 'button-group';

    // calendar
    case CALENDAR = 'calendar';

    // card
    case CARD = 'card';
    case CARD_ACTION = 'card-action';
    case CARD_CONTENT = 'card-content';
    case CARD_DESCRIPTION = 'card-description';
    case CARD_FOOTER = 'card-footer';
    case CARD_HEADER = 'card-header';
    case CARD_TITLE = 'card-title';

    // carousel
    case CAROUSEL = 'carousel';
    case CAROUSEL_CONTENT = 'carousel-content';
    case CAROUSEL_ITEM = 'carousel-item';
    case CAROUSEL_NEXT = 'carousel-next';
    case CAROUSEL_PREVIOUS = 'carousel-previous';

    // chart
    case CHART = 'chart';
    case CHART_BAR = 'chart-bar';

    // checkbox
    case CHECKBOX = 'checkbox';

    // collapsible
    case COLLAPSIBLE = 'collapsible';
    case COLLAPSIBLE_CONTENT = 'collapsible-content';
    case COLLAPSIBLE_TRIGGER = 'collapsible-trigger';

    // combobox
    case COMBOBOX = 'combobox';
    case COMBOBOX_CONTENT = 'combobox-content';
    case COMBOBOX_INPUT = 'combobox-input';
    case COMBOBOX_ITEM = 'combobox-item';

    // command
    case COMMAND = 'command';
    case COMMAND_EMPTY = 'command-empty';
    case COMMAND_GROUP = 'command-group';
    case COMMAND_INPUT = 'command-input';
    case COMMAND_ITEM = 'command-item';
    case COMMAND_LIST = 'command-list';
    case COMMAND_SEPARATOR = 'command-separator';

    // context
    case CONTEXT_MENU = 'context-menu';
    case CONTEXT_MENU_CONTENT = 'context-menu-content';
    case CONTEXT_MENU_ITEM = 'context-menu-item';
    case CONTEXT_MENU_LABEL = 'context-menu-label';
    case CONTEXT_MENU_SEPARATOR = 'context-menu-separator';
    case CONTEXT_MENU_TRIGGER = 'context-menu-trigger';

    // dark
    case DARK_MODE_TOGGLE = 'dark-mode-toggle';

    // dialog
    case DIALOG = 'dialog';
    case DIALOG_CLOSE = 'dialog-close';
    case DIALOG_CONTENT = 'dialog-content';
    case DIALOG_DESCRIPTION = 'dialog-description';
    case DIALOG_FOOTER = 'dialog-footer';
    case DIALOG_HEADER = 'dialog-header';
    case DIALOG_TITLE = 'dialog-title';
    case DIALOG_TRIGGER = 'dialog-trigger';

    // drawer
    case DRAWER = 'drawer';
    case DRAWER_CLOSE = 'drawer-close';
    case DRAWER_CONTENT = 'drawer-content';
    case DRAWER_DESCRIPTION = 'drawer-description';
    case DRAWER_FOOTER = 'drawer-footer';
    case DRAWER_HEADER = 'drawer-header';
    case DRAWER_TITLE = 'drawer-title';
    case DRAWER_TRIGGER = 'drawer-trigger';

    // dropdown
    case DROPDOWN_MENU = 'dropdown-menu';
    case DROPDOWN_MENU_CONTENT = 'dropdown-menu-content';
    case DROPDOWN_MENU_ITEM = 'dropdown-menu-item';
    case DROPDOWN_MENU_LABEL = 'dropdown-menu-label';
    case DROPDOWN_MENU_SEPARATOR = 'dropdown-menu-separator';
    case DROPDOWN_MENU_SHORTCUT = 'dropdown-menu-shortcut';
    case DROPDOWN_MENU_TRIGGER = 'dropdown-menu-trigger';

    // empty
    case EMPTY = 'empty';
    case EMPTY_CONTENT = 'empty-content';
    case EMPTY_DESCRIPTION = 'empty-description';
    case EMPTY_HEADER = 'empty-header';
    case EMPTY_MEDIA = 'empty-media';
    case EMPTY_TITLE = 'empty-title';

    // field
    case FIELD = 'field';
    case FIELD_DESCRIPTION = 'field-description';
    case FIELD_ERROR = 'field-error';
    case FIELD_LABEL = 'field-label';

    // file
    case FILE_INPUT = 'file-input';

    // form
    case FORM = 'form';
    case FORM_ITEM = 'form-item';

    // hover
    case HOVER_CARD = 'hover-card';
    case HOVER_CARD_CONTENT = 'hover-card-content';
    case HOVER_CARD_TRIGGER = 'hover-card-trigger';

    // input
    case INPUT = 'input';

    // kbd
    case KBD = 'kbd';
    case KBD_GROUP = 'kbd-group';

    // marquee
    case MARQUEE = 'marquee';

    // menubar
    case MENUBAR = 'menubar';
    case MENUBAR_CONTENT = 'menubar-content';
    case MENUBAR_ITEM = 'menubar-item';
    case MENUBAR_MENU = 'menubar-menu';
    case MENUBAR_SEPARATOR = 'menubar-separator';
    case MENUBAR_TRIGGER = 'menubar-trigger';

    // navigation
    case NAVIGATION_MENU = 'navigation-menu';
    case NAVIGATION_MENU_CONTENT = 'navigation-menu-content';
    case NAVIGATION_MENU_ITEM = 'navigation-menu-item';
    case NAVIGATION_MENU_LINK = 'navigation-menu-link';
    case NAVIGATION_MENU_LIST = 'navigation-menu-list';
    case NAVIGATION_MENU_TRIGGER = 'navigation-menu-trigger';

    // pagination
    case PAGINATION = 'pagination';
    case PAGINATION_CONTENT = 'pagination-content';
    case PAGINATION_ELLIPSIS = 'pagination-ellipsis';
    case PAGINATION_ITEM = 'pagination-item';
    case PAGINATION_LINK = 'pagination-link';
    case PAGINATION_NEXT = 'pagination-next';
    case PAGINATION_PREVIOUS = 'pagination-previous';

    // popover
    case POPOVER = 'popover';
    case POPOVER_CONTENT = 'popover-content';
    case POPOVER_TRIGGER = 'popover-trigger';

    // progress
    case PROGRESS = 'progress';

    // radio
    case RADIO = 'radio';
    case RADIO_GROUP = 'radio-group';
    case RADIO_GROUP_ITEM = 'radio-group-item';

    // rating
    case RATING = 'rating';

    // resizable
    case RESIZABLE_HANDLE = 'resizable-handle';
    case RESIZABLE_PANEL = 'resizable-panel';
    case RESIZABLE_PANEL_GROUP = 'resizable-panel-group';

    // scroll
    case SCROLL_AREA = 'scroll-area';

    // select
    case SELECT = 'select';

    // separator
    case SEPARATOR = 'separator';

    // sheet
    case SHEET = 'sheet';
    case SHEET_CLOSE = 'sheet-close';
    case SHEET_CONTENT = 'sheet-content';
    case SHEET_DESCRIPTION = 'sheet-description';
    case SHEET_FOOTER = 'sheet-footer';
    case SHEET_HEADER = 'sheet-header';
    case SHEET_TITLE = 'sheet-title';
    case SHEET_TRIGGER = 'sheet-trigger';

    // sidebar
    case SIDEBAR = 'sidebar';
    case SIDEBAR_CONTENT = 'sidebar-content';
    case SIDEBAR_FOOTER = 'sidebar-footer';
    case SIDEBAR_HEADER = 'sidebar-header';
    case SIDEBAR_INSET = 'sidebar-inset';
    case SIDEBAR_MENU = 'sidebar-menu';
    case SIDEBAR_MENU_BUTTON = 'sidebar-menu-button';
    case SIDEBAR_MENU_ITEM = 'sidebar-menu-item';
    case SIDEBAR_PROVIDER = 'sidebar-provider';
    case SIDEBAR_TRIGGER = 'sidebar-trigger';

    // skeleton
    case SKELETON = 'skeleton';

    // slider
    case SLIDER = 'slider';

    // spinner
    case SPINNER = 'spinner';

    // spotlight
    case SPOTLIGHT = 'spotlight';

    // stepper
    case STEPPER = 'stepper';
    case STEPPER_DESCRIPTION = 'stepper-description';
    case STEPPER_ITEM = 'stepper-item';
    case STEPPER_TITLE = 'stepper-title';

    // switch
    case SWITCH = 'switch';

    // table
    case TABLE = 'table';
    case TABLE_BODY = 'table-body';
    case TABLE_CAPTION = 'table-caption';
    case TABLE_CELL = 'table-cell';
    case TABLE_FOOTER = 'table-footer';
    case TABLE_HEAD = 'table-head';
    case TABLE_HEADER = 'table-header';
    case TABLE_ROW = 'table-row';

    // tabs
    case TABS = 'tabs';
    case TABS_CONTENT = 'tabs-content';
    case TABS_LIST = 'tabs-list';
    case TABS_TRIGGER = 'tabs-trigger';

    // textarea
    case TEXTAREA = 'textarea';

    // timeline
    case TIMELINE = 'timeline';
    case TIMELINE_CONTENT = 'timeline-content';
    case TIMELINE_DESCRIPTION = 'timeline-description';
    case TIMELINE_INDICATOR = 'timeline-indicator';
    case TIMELINE_ITEM = 'timeline-item';
    case TIMELINE_TITLE = 'timeline-title';

    // toast
    case TOAST = 'toast';
    case TOAST_ACTION = 'toast-action';
    case TOAST_CLOSE = 'toast-close';
    case TOAST_DESCRIPTION = 'toast-description';

    // toaster
    case TOASTER = 'toaster';

    // toast
    case TOAST_TITLE = 'toast-title';

    // toggle
    case TOGGLE = 'toggle';
    case TOGGLE_GROUP = 'toggle-group';
    case TOGGLE_GROUP_ITEM = 'toggle-group-item';

    // tooltip
    case TOOLTIP = 'tooltip';
    case TOOLTIP_CONTENT = 'tooltip-content';
    case TOOLTIP_TRIGGER = 'tooltip-trigger';
}
