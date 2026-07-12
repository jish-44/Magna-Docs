<?php

declare(strict_types=1);

namespace Magna\Docs\Support;

class TocGenerator
{
    /**
     * Parse h2/h3 headings from rendered HTML and return a structured TOC.
     *
     * @return list<array{level: int, id: string, text: string}>
     */
    public static function generate(string $html): array
    {
        if (blank($html)) {
            return [];
        }

        // Match each h2/h3 block. The id lives on the permalink <a> inside the
        // heading (CommonMark HeadingPermalinkExtension), not on the h tag.
        preg_match_all('/<h([23])\b[^>]*>(.*?)<\/h\1>/is', $html, $matches, PREG_SET_ORDER);

        $toc = [];
        foreach ($matches as $match) {
            if (preg_match('/\sid="([^"]+)"/i', $match[2], $idMatch) !== 1) {
                continue;
            }

            // Drop the permalink anchor (the "#") before extracting clean text.
            $text = trim(strip_tags(
                (string) preg_replace('#<a\b[^>]*heading-permalink[^>]*>.*?</a>#is', '', $match[2])
            ));

            if ($text === '') {
                continue;
            }

            $toc[] = [
                'level' => (int) $match[1],
                'id' => $idMatch[1],
                'text' => $text,
            ];
        }

        return $toc;
    }
}
