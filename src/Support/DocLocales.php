<?php

declare(strict_types=1);

namespace Magna\Docs\Support;

class DocLocales
{
    /**
     * Supported docs languages. 'en' is always the default (the page itself);
     * the rest are stored as translations.
     *
     * @var array<string, array{0: string, 1: string}> [flag, label]
     */
    public const LABELS = [
        'en' => ['🇬🇧', 'English'],
        'es' => ['🇪🇸', 'Spanish'],
        'fr' => ['🇫🇷', 'French'],
        'de' => ['🇩🇪', 'German'],
        'it' => ['🇮🇹', 'Italian'],
        'pt' => ['🇵🇹', 'Portuguese'],
        'nl' => ['🇳🇱', 'Dutch'],
        'ru' => ['🇷🇺', 'Russian'],
        'uk' => ['🇺🇦', 'Ukrainian'],
        'pl' => ['🇵🇱', 'Polish'],
        'sv' => ['🇸🇪', 'Swedish'],
        'no' => ['🇳🇴', 'Norwegian'],
        'da' => ['🇩🇰', 'Danish'],
        'fi' => ['🇫🇮', 'Finnish'],
        'cs' => ['🇨🇿', 'Czech'],
        'el' => ['🇬🇷', 'Greek'],
        'tr' => ['🇹🇷', 'Turkish'],
        'ar' => ['🇸🇦', 'Arabic'],
        'he' => ['🇮🇱', 'Hebrew'],
        'fa' => ['🇮🇷', 'Persian'],
        'ur' => ['🇵🇰', 'Urdu'],
        'hi' => ['🇮🇳', 'Hindi'],
        'bn' => ['🇧🇩', 'Bengali'],
        'pa' => ['🇮🇳', 'Punjabi'],
        'ta' => ['🇮🇳', 'Tamil'],
        'te' => ['🇮🇳', 'Telugu'],
        'ml' => ['🇮🇳', 'Malayalam'],
        'kn' => ['🇮🇳', 'Kannada'],
        'mr' => ['🇮🇳', 'Marathi'],
        'gu' => ['🇮🇳', 'Gujarati'],
        'zh' => ['🇨🇳', 'Chinese'],
        'ja' => ['🇯🇵', 'Japanese'],
        'ko' => ['🇰🇷', 'Korean'],
        'vi' => ['🇻🇳', 'Vietnamese'],
        'th' => ['🇹🇭', 'Thai'],
        'id' => ['🇮🇩', 'Indonesian'],
        'ms' => ['🇲🇾', 'Malay'],
        'fil' => ['🇵🇭', 'Filipino'],
        'sw' => ['🇰🇪', 'Swahili'],
        'af' => ['🇿🇦', 'Afrikaans'],
        'ro' => ['🇷🇴', 'Romanian'],
        'hu' => ['🇭🇺', 'Hungarian'],
    ];

    public static function isValid(string $locale): bool
    {
        return array_key_exists($locale, self::LABELS);
    }

    public static function label(string $locale): string
    {
        return self::LABELS[$locale][1] ?? strtoupper($locale);
    }

    public static function flag(string $locale): string
    {
        return self::LABELS[$locale][0] ?? '🏳️';
    }
}
