<?php

use Illuminate\Support\Facades\Route;
use Magna\Docs\Http\Controllers\DocsPageController;

Route::get('/docs/sitemap.xml', [DocsPageController::class, 'sitemap'])
    ->name('docs.web.sitemap');

// Plugin's own pre-built CSS/JS, served statically (no host build step needed).
Route::get('/docs/asset/{file}', [DocsPageController::class, 'asset'])
    ->where('file', '[A-Za-z0-9._-]+')
    ->name('docs.web.asset');

Route::get('/docs/search', [DocsPageController::class, 'search'])
    ->name('docs.web.search');

// POST (state-changing) + throttled to blunt vote-stuffing. Validates the slug
// server-side (see controller) so arbitrary cache keys can't be created.
Route::post('/docs/feedback', [DocsPageController::class, 'feedback'])
    ->middleware('throttle:20,1')
    ->name('docs.web.feedback');

Route::get('/docs', [DocsPageController::class, 'index'])
    ->name('docs.web.index');

Route::get('/docs/{slug}', [DocsPageController::class, 'show'])
    ->name('docs.web.show');
