<?php

use Illuminate\Support\Facades\Route;
use Magna\Docs\Http\Controllers\DeliveryController;

// These read endpoints only ever return published pages, so they're left
// open (no `can:` gate) — a static-site build step has no user session to
// authenticate with. If you need to preview drafts, add a separate
// authenticated route rather than loosening these.

// GET /api/v1/docs/tree
Route::middleware(['magna.api'])
    ->get('/tree', [DeliveryController::class, 'tree'])
    ->name('docs.tree');

// GET /api/v1/docs/pages
Route::middleware(['magna.api'])
    ->get('/pages', [DeliveryController::class, 'index'])
    ->name('docs.pages.index');

// GET /api/v1/docs/pages/{slug}
Route::middleware(['magna.api'])
    ->get('/pages/{slug}', [DeliveryController::class, 'show'])
    ->name('docs.pages.show');
