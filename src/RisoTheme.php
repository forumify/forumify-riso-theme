<?php

declare(strict_types=1);

namespace Forumify\RisoTheme;

use Forumify\ForumifyTheme;
use Forumify\Plugin\PluginMetadata;
use Forumify\Plugin\ThemeConfig;
use Forumify\Plugin\ThemeVar;
use Forumify\Plugin\ThemeVarType;

/**
 * A risograph print zine: two fluorescent inks on recycled paper, printed slightly out
 * of register.
 *
 * forumify's own variables keep their meaning, only their defaults change, so the admin
 * panel and every plugin pick up the palette. The riso-* variables drive the effects in
 * public/style.css and can be tuned under Admin → Settings → Themes.
 */
class RisoTheme extends ForumifyTheme
{
    /**
     * New defaults for forumify's own variables, as [light, dark].
     */
    private const OVERRIDES = [
        'c-primary' => ['#2b3d8f', '#8fb4ff'],
        'c-primary-accent' => ['#0078bf', '#b8d0ff'],
        'c-primary-text' => ['#f6f6f1', '#14163a'],
        'c-secondary' => ['#ffe800', '#ffe800'],
        'c-secondary-text' => ['#1f2148', '#1f2148'],
        'c-call-to-action' => ['#ff48b0', '#ff48b0'],
        'c-call-to-action-accent' => ['#f0249a', '#ff74c4'],
        'c-call-to-action-text' => ['#1f2148', '#14163a'],
        'c-text-primary' => ['#1f2148', '#f2efff'],
        'c-text-secondary' => ['#55577a', '#b7b5d9'],
        'c-success' => ['#bff0d4', '#0f4a3a'],
        'c-success-text' => ['#0b3d2b', '#a7f5d0'],
        'c-info' => ['#c9e2ff', '#16336b'],
        'c-info-text' => ['#12305f', '#c4dcff'],
        'c-warning' => ['#fff27a', '#4d4100'],
        'c-warning-text' => ['#3d3000', '#fff27a'],
        'c-error' => ['#ffc2dc', '#5c0f35'],
        'c-error-text' => ['#6a0035', '#ffc2dc'],
        'c-elevation-0' => ['#eceeea', '#14163a'],
        'c-elevation-1' => ['#fbfbf8', '#1c1f4c'],
        'c-elevation-2' => ['#f3f3ee', '#24285c'],
        'c-elevation-3' => ['#e8e9e3', '#2c3168'],
        'c-elevation-4' => ['#dfe0d9', '#343a74'],
        'c-elevation-5' => ['#d5d6cf', '#3c4280'],
        'c-hover' => ['rgba(255, 72, 176, 0.09)', 'rgba(255, 72, 176, 0.14)'],
        'border-width' => ['2px', '2px'],
        'border-color' => ['#1f2148', '#f2efff'],
        'border-radius' => ['0px', '0px'],
        'button-border-radius' => ['0px', '0px'],
        'font-size' => ['16px', '16px'],
    ];

    public function getPluginMetadata(): PluginMetadata
    {
        return new PluginMetadata(
            'Riso',
            'forumify',
            'A risograph print zine: fluorescent inks, misregistered offset shadows and paper grain.',
            'https://forumify.net',
        );
    }

    public function getThemeConfig(): ThemeConfig
    {
        $vars = array_map(static function (ThemeVar $var): ThemeVar {
            if (!isset(self::OVERRIDES[$var->key])) {
                return $var;
            }

            [$light, $dark] = self::OVERRIDES[$var->key];
            return new ThemeVar($var->key, $var->label, $var->type, $light, $dark, $var->help);
        }, parent::getThemeConfig()->vars);

        return new ThemeConfig(true, [
            ...$vars,
            new ThemeVar(
                'color-scheme',
                'Color Scheme',
                ThemeVarType::String,
                'light',
                'dark',
                'Tells the browser whether native controls and scrollbars should be light or dark.',
            ),
            new ThemeVar('riso-ink', 'Ink', ThemeVarType::Color, '#1f2148', '#f2efff', 'Outlines, rules and the hard shadow behind buttons.'),
            new ThemeVar('riso-pink', 'Fluorescent Pink', ThemeVarType::Color, '#ff48b0', '#ff48b0', 'The second ink: offset shadows and misregistered headings.'),
            new ThemeVar('riso-blue', 'Blue', ThemeVarType::Color, '#0078bf', '#4aa3ff'),
            new ThemeVar('riso-yellow', 'Yellow', ThemeVarType::Color, '#ffe800', '#ffe800'),
            new ThemeVar('riso-paper', 'Paper', ThemeVarType::Color, '#eceeea', '#14163a', 'Page background, usually the same as Elevation 0.'),
            new ThemeVar('riso-offset', 'Misregistration Offset', ThemeVarType::Size, '6px', '6px', 'How far the pink layer is printed out of register.'),
            new ThemeVar('riso-grain', 'Paper Grain', ThemeVarType::String, '0.5', '0.35', 'Opacity of the paper grain, between 0 and 1.'),
            new ThemeVar('riso-font', 'Font Family', ThemeVarType::String, "'Bricolage Grotesque', sans-serif"),
        ]);
    }

    /**
     * Stylesheets loaded on every page while the theme is active, relative to public/.
     *
     * @return array<string>
     */
    public function getStylesheets(): array
    {
        return ['style.css'];
    }
}
