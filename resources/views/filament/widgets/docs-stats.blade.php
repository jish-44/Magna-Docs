{{-- Custom Magna Docs dashboard card. Styling lives in a scoped <style> block
     (not Tailwind utilities) because the admin panel's compiled theme CSS does
     not include arbitrary utility classes used only here. --}}
<div class="mdw-card">
    <style>
        .mdw-card {
            width: 100%;
            border-radius: 1rem;
            border: 1px solid rgba(226, 232, 240, .8);
            background: #fff;
            padding: 1.5rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .05);
            transition: box-shadow .2s ease;
        }
        .mdw-card:hover { box-shadow: 0 4px 12px -2px rgba(0, 0, 0, .08); }
        /* Match the dark "glass panel" surface used by the other dashboard cards
           (see theme.css → .dark .fi-section / .fi-wi-widget). */
        .dark .mdw-card {
            background: linear-gradient(160deg, rgba(20, 27, 45, 0.75) 0%, rgba(13, 18, 30, 0.85) 100%);
            border-color: rgba(255, 255, 255, 0.06);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        /* Header */
        .mdw-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .dark .mdw-head { border-bottom-color: rgba(39, 39, 42, .5); }
        .mdw-head-l { display: flex; align-items: center; gap: .75rem; }
        .mdw-icon {
            display: flex; align-items: center; justify-content: center;
            height: 2.5rem; width: 2.5rem;
            border-radius: .75rem;
            background: #f5f3ff; color: #7c3aed;
            flex-shrink: 0;
        }
        .dark .mdw-icon { background: rgba(46, 16, 101, .4); color: #a78bfa; }
        .mdw-icon svg { height: 1.25rem; width: 1.25rem; }
        .mdw-title {
            font-size: 1rem; line-height: 1.5rem; font-weight: 700;
            letter-spacing: -.015em; color: #0f172a; margin: 0;
        }
        .dark .mdw-title { color: #fff; }
        .mdw-sub {
            font-size: .75rem; line-height: 1rem; font-weight: 500;
            color: #94a3b8; margin: 0;
        }
        .dark .mdw-sub { color: #71717a; }

        /* Stats grid */
        .mdw-grid {
            margin-top: 1.25rem;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: .5rem;
            text-align: center;
        }
        .mdw-stat {
            position: relative; display: block;
            border-radius: .75rem;
            border: 1px solid transparent;
            padding: .75rem;
            text-decoration: none;
            transition: transform .2s ease, background-color .2s ease, border-color .2s ease;
        }
        .mdw-stat:hover { transform: translateY(-2px); }
        .mdw-ext {
            position: absolute; top: .375rem; right: .375rem;
            opacity: 0; transition: opacity .2s ease;
        }
        .mdw-stat:hover .mdw-ext { opacity: 1; }
        .mdw-ext svg { height: .625rem; width: .625rem; }
        .mdw-num {
            display: block;
            font-size: 1.5rem; line-height: 2rem;
            font-weight: 800; letter-spacing: -.015em;
            transition: color .2s ease;
        }
        .mdw-label {
            margin-top: .25rem; display: block;
            font-size: .625rem; line-height: .875rem;
            font-weight: 700; text-transform: uppercase; letter-spacing: .05em;
            transition: color .2s ease;
        }

        /* Collections (primary / violet) */
        .mdw-stat--primary { background: rgba(248, 250, 252, .6); }
        .mdw-stat--primary:hover { border-color: rgba(139, 92, 246, .3); background: rgba(245, 243, 255, .3); }
        .mdw-stat--primary .mdw-num { color: #0f172a; }
        .mdw-stat--primary .mdw-label { color: #64748b; }
        .mdw-stat--primary:hover .mdw-num { color: #8b5cf6; }
        .mdw-stat--primary:hover .mdw-label { color: rgba(139, 92, 246, .8); }
        .mdw-stat--primary .mdw-ext { color: #94a3b8; }
        .dark .mdw-stat--primary { background: rgba(24, 24, 27, .3); }
        .dark .mdw-stat--primary:hover { border-color: rgba(139, 92, 246, .3); background: rgba(46, 16, 101, .1); }
        .dark .mdw-stat--primary .mdw-num { color: #fff; }
        .dark .mdw-stat--primary .mdw-label { color: #a1a1aa; }
        .dark .mdw-stat--primary .mdw-ext { color: #71717a; }

        /* Published (success / emerald) */
        .mdw-stat--success { background: rgba(236, 253, 245, .4); }
        .mdw-stat--success:hover { border-color: rgba(16, 185, 129, .3); background: rgba(236, 253, 245, .7); }
        .mdw-stat--success .mdw-num { color: #059669; }
        .mdw-stat--success .mdw-label { color: rgba(5, 150, 105, .8); }
        .mdw-stat--success .mdw-ext { color: rgba(16, 185, 129, .7); }
        .dark .mdw-stat--success { background: rgba(2, 44, 34, .28); }
        .dark .mdw-stat--success:hover { border-color: rgba(16, 185, 129, .2); background: rgba(2, 44, 34, .45); }
        .dark .mdw-stat--success .mdw-num { color: #34d399; }
        .dark .mdw-stat--success .mdw-label { color: rgba(52, 211, 153, .8); }
        .dark .mdw-stat--success .mdw-ext { color: rgba(52, 211, 153, .6); }

        /* Drafts (muted / slate) */
        .mdw-stat--muted { background: rgba(248, 250, 252, .6); }
        .mdw-stat--muted:hover { border-color: rgba(148, 163, 184, .3); background: rgba(241, 245, 249, .5); }
        .mdw-stat--muted .mdw-num { color: #94a3b8; }
        .mdw-stat--muted .mdw-label { color: #94a3b8; }
        .mdw-stat--muted:hover .mdw-num { color: #475569; }
        .mdw-stat--muted:hover .mdw-label { color: #64748b; }
        .mdw-stat--muted .mdw-ext { color: #94a3b8; }
        .dark .mdw-stat--muted { background: rgba(24, 24, 27, .3); }
        .dark .mdw-stat--muted:hover { border-color: rgba(63, 63, 70, .5); background: rgba(39, 39, 42, .3); }
        .dark .mdw-stat--muted .mdw-num { color: #71717a; }
        .dark .mdw-stat--muted .mdw-label { color: #71717a; }
        .dark .mdw-stat--muted:hover .mdw-num { color: #d4d4d8; }
        .dark .mdw-stat--muted:hover .mdw-label { color: #a1a1aa; }
        .dark .mdw-stat--muted .mdw-ext { color: #71717a; }
    </style>

    <div class="mdw-head">
        <div class="mdw-head-l">
            <div class="mdw-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <h3 class="mdw-title">Magna Docs</h3>
                <p class="mdw-sub">Documentation Overview</p>
            </div>
        </div>
    </div>

    <div class="mdw-grid">
        <a href="{{ $collectionsUrl }}" wire:navigate class="mdw-stat mdw-stat--primary">
            <span class="mdw-ext">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
            </span>
            <span class="mdw-num">{{ $collections }}</span>
            <span class="mdw-label">Collections</span>
        </a>

        <a href="{{ $publishedUrl }}" wire:navigate class="mdw-stat mdw-stat--success">
            <span class="mdw-ext">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
            </span>
            <span class="mdw-num">{{ $published }}</span>
            <span class="mdw-label">Published</span>
        </a>

        <a href="{{ $draftsUrl }}" wire:navigate class="mdw-stat mdw-stat--muted">
            <span class="mdw-ext">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
            </span>
            <span class="mdw-num">{{ $drafts }}</span>
            <span class="mdw-label">Drafts</span>
        </a>
    </div>
</div>
