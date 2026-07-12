/**
 * Tailwind v3 config for the docs front-end — mirrors the inline config that
 * the Tailwind Play CDN (v3) used, so the compiled output is identical.
 *
 * Rebuild the committed stylesheet after changing any front-end blade:
 *
 *   cd plugins-dev/magna/docs
 *   npx tailwindcss@3 -c tailwind.config.js -i resources/css/app.css -o public/docs.css --minify
 *
 * @type {import('tailwindcss').Config}
 */
module.exports = {
    darkMode: 'class',
    content: [
        './resources/views/layout.blade.php',
        './resources/views/pages/**/*.blade.php',
        './resources/views/partials/**/*.blade.php',
    ],
    // Utilities toggled at runtime by JS (the Play CDN caught these via a live
    // DOM observer; a static build needs them listed explicitly).
    safelist: [
        'rotate-90',
        '-translate-x-full',
        'translate-x-full',
        'hidden',
    ],
    theme: {
        extend: {
            colors: {
                brand: { light: '#a78bfa', DEFAULT: '#8b5cf6', dark: '#7c3aed' },
                darkBg: '#0f0f11',
                darkCard: '#161619',
            },
        },
    },
};
