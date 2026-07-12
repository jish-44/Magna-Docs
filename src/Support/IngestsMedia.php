<?php

declare(strict_types=1);

namespace Magna\Docs\Support;

/**
 * Backward-compatible re-export.
 * The implementation lives in core as Magna\Media\Concerns\IngestsMedia.
 * Existing usages of this class-name continue to work unchanged.
 */
trait IngestsMedia
{
    use \Magna\Media\Concerns\IngestsMedia;
}
