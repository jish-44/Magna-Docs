<?php

declare(strict_types=1);

namespace Magna\Docs\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Magna\Docs\Models\DocPage;
use Magna\Docs\Support\DocTree;

class DeliveryController
{
    /**
     * GET /api/v1/docs/tree
     *
     * Nested sidebar structure, for any external consumer that wants the
     * raw JSON instead of the server-rendered HTML frontend.
     */
    public function tree(): JsonResponse
    {
        return response()->json(['data' => DocTree::build()]);
    }

    /**
     * GET /api/v1/docs/pages
     *
     * Flat list of published pages — useful for building a search index.
     */
    public function index(): JsonResponse
    {
        $pages = DocPage::query()
            ->where('status', 'published')
            ->orderBy('order')
            ->get(['id', 'parent_id', 'title', 'slug', 'excerpt', 'updated_at']);

        return response()->json(['data' => $pages]);
    }

    /**
     * GET /api/v1/docs/pages/{slug}
     *
     * Full page content plus breadcrumb, for rendering a single doc page.
     */
    public function show(string $slug): JsonResponse
    {
        $page = DocPage::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return response()->json([
            'data' => [
                'title' => $page->title,
                'slug' => $page->slug,
                'excerpt' => $page->excerpt,
                'content' => $page->content,
                'breadcrumb' => $page->breadcrumb(),
                'updated_at' => $page->updated_at,
            ],
        ]);
    }
}
