<?php

declare(strict_types=1);

namespace Magna\Docs\Support;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\MarkdownConverter;

class MarkdownRenderer
{
    private static ?MarkdownConverter $converter = null;

    public static function toHtml(?string $markdown): string
    {
        if (blank($markdown)) {
            return '';
        }

        return (string) self::converter()->convert($markdown);
    }

    private static function converter(): MarkdownConverter
    {
        if (self::$converter !== null) {
            return self::$converter;
        }

        $environment = new Environment([
            // Doc content is rendered unescaped ({!! $html !!}) on the public site,
            // so treat the Markdown source as untrusted: strip any raw HTML and
            // reject javascript:/data: style links. Without this, an editor could
            // store XSS that runs for every visitor. (Fenced code blocks and the
            // permalink/table extensions are unaffected — this only governs raw
            // HTML embedded in the Markdown source.)
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
            'heading_permalink' => [
                'html_class' => 'heading-permalink',
                'id_prefix' => '',
                'fragment_prefix' => '',
                'insert' => 'after',
                'symbol' => '#',
            ],
        ]);

        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new HeadingPermalinkExtension);
        $environment->addExtension(new TableExtension);

        return self::$converter = new MarkdownConverter($environment);
    }
}
