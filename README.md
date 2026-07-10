# Magna Docs

**A beautiful, full-featured documentation plugin for [Magna CMS](https://github.com/your-org/magna-cms).**

Write, organize, and publish developer documentation — or any long-form reference content — right inside your Laravel/Filament admin panel. No separate toolchain, no rebuild step, no Node.js required.

> **License:** MIT  
> **Requires:** PHP 8.3+, Laravel 11+, Magna CMS, Filament 3

---

<!-- SCREENSHOT: Hero — full-screen editor open on a doc page, dark mode -->
> 📸 *Screenshot: Full-screen editor in dark mode*

---

## Why Magna Docs instead of VitePress / Docusaurus / GitBook?

| Feature | Magna Docs | VitePress / Docusaurus | GitBook / Notion |
|---|---|---|---|
| Runs inside your existing Laravel app | ✅ | ❌ Separate process/deploy | ❌ External SaaS |
| Edits are live instantly (no rebuild) | ✅ | ❌ Must re-run `vite build` | ✅ |
| Fully server-rendered HTML (no React/Vue in browser) | ✅ | ❌ JS framework required | ❌ |
| SEO-ready out of the box | ✅ | ✅ | ⚠️ Limited on free tier |
| Sitemap.xml auto-generated | ✅ | ✅ (with plugin) | ❌ |
| Role-based editor permissions | ✅ | ❌ | ✅ (paid) |
| Nestable pages + collections | ✅ | ✅ | ✅ |
| Dark mode | ✅ | ✅ | ✅ |
| Full-screen distraction-free editor | ✅ | ❌ | ✅ |
| Self-hosted, open-source | ✅ | ✅ | ❌ |
| Media library integration | ✅ | ❌ | ❌ |
| REST API for headless consumption | ✅ | ❌ | ✅ (paid) |
| Custom domain support | ✅ | ✅ | ✅ (paid) |
| Zero build step / no Node.js | ✅ | ❌ Requires Node | ❌ |

The core difference: static-site generators compile at build time, so every content edit requires a rebuild and redeploy. Magna Docs renders directly from the database on each request — so saving a draft in the admin is live on the next page load. Since the app is already a running Laravel process, there is nothing extra to operate.

---

## Features

### Full-screen Markdown Editor

<!-- SCREENSHOT: Editor topbar with Save Draft / Publish buttons, dark/light toggle -->
> 📸 *Screenshot: Editor topbar*

- Distraction-free overlay editor covers the entire screen — no Filament chrome visible while writing.
- **Markdown** with rich toolbar: bold, italic, strikethrough, links, headings, bullet/ordered lists, blockquotes, code blocks, tables, and file attachments.
- **Dark / light mode toggle** — persists across saves and page reloads.
- **Auto-save-aware workflow**: Save Draft silently saves without redirecting; Publish sets the status to published and shows a confirmation toast.
- **Auto-slug generation**: slug is derived from the title while typing; you can override it manually.

### Draft / Publish Workflow

<!-- SCREENSHOT: Sidebar Summary section showing "Draft" status pill and "Publish page" button -->
> 📸 *Screenshot: Sidebar — draft status*

- Every page starts as a **draft** and is invisible to visitors until published.
- Status is shown as a styled badge in the sidebar (Draft / Published / Archived).
- **Publish date** field appears automatically once a page is published, letting you record when it went live.
- The topbar button changes to **Update** once a page is already published, so you always know what action you're taking.

### Collections & Nested Pages

<!-- SCREENSHOT: Sidebar showing collection groups with nested pages -->
> 📸 *Screenshot: Frontend sidebar with collection groups*

- **Collections** group related pages (e.g. "Getting Started", "API Reference"). Each collection has a title, slug, description, icon, color, and sort order.
- **Nested pages**: any page can be a child of another page (`parent_id`), creating a hierarchy of unlimited depth.
- The sidebar on the public frontend is auto-built from this tree — no manual menu configuration needed.
- **Drag-order**: set the `order` field to control where a page appears within its group.

### Auto Table of Contents

<!-- SCREENSHOT: Right sidebar showing TOC with h2/h3 headings linked -->
> 📸 *Screenshot: In-page Table of Contents*

- Every `h2` and `h3` heading in the rendered content is extracted and rendered as a clickable anchor list in the right-hand column.
- Headings get permanent `#` permalink anchors (via CommonMark's heading-permalink extension), so links to specific sections survive refactoring.

### SEO — Zero Config

No plugin, no extra config file. Every page ships:

- Unique `<title>` (meta title field, falls back to page title)
- `<meta name="description">` (meta description field, falls back to truncated excerpt)
- Canonical URL
- Open Graph tags (`og:title`, `og:description`, `og:image`, `og:type`, `og:site_name`)
- Twitter card tags
- JSON-LD structured data: `TechArticle` and `BreadcrumbList`
- Auto-generated `sitemap.xml` at `/docs/sitemap.xml` with `<lastmod>` per page

### Server-Rendered, No Build Step

The frontend is pure Blade + inline CSS. There is no JavaScript framework shipped to the browser — only a small amount of vanilla JS for the Table of Contents scroll-spy and feedback widget. This means:

- **No `npm run build`** required after content changes.
- **Instant previews** — published pages are live on the next browser refresh.
- **Fast by default** — fully-formed HTML is sent on the first request; no hydration delay.
- Rendered HTML is cached per page (keyed on `page_id:updated_at`) and automatically invalidated the moment a page is saved.

### Featured Image

<!-- SCREENSHOT: Featured image section in sidebar — showing preview of selected image -->
> 📸 *Screenshot: Featured image picker*

- Upload an image directly from the editor sidebar (16:9 crop, auto-resized).
- **Or** pick from the Magna media library — browse all uploaded images in a modal, select with one click.
- Toggle whether the featured image appears on the frontend per-page.

### Breadcrumb & Prev / Next Navigation

<!-- SCREENSHOT: Page footer showing ← Previous / Next → navigation cards -->
> 📸 *Screenshot: Prev/Next navigation*

- Full breadcrumb trail rendered at the top of each page, based on `parent_id` hierarchy.
- Prev / Next navigation cards at the bottom of each page — automatically picks the adjacent page in sidebar order.

### Reading Time & Last Updated

- Reading time is calculated from word count (~200 wpm) and shown in the page footer.
- "Last updated" date rendered from `updated_at` — always accurate, no manual maintenance.

### Page Feedback Widget

<!-- SCREENSHOT: "Was this page helpful? 👍 👎" section at the bottom of a page -->
> 📸 *Screenshot: Feedback widget*

- Every published page has a "Was this page helpful?" widget at the bottom.
- Sends a `POST` to a lightweight endpoint; no external service required.

### Docs Settings

<!-- SCREENSHOT: Docs Settings admin page showing branding fields -->
> 📸 *Screenshot: Docs Settings page*

Configure everything from the admin panel under **Magna Docs → Settings**:

| Setting | Description |
|---|---|
| **Custom domain** | Serve docs at `docs.yoursite.com` instead of `/docs` |
| **Site name** | Override the header/tab title for the docs section |
| **Logo** | Upload or pick from media library; falls back to CMS logo |
| **Favicon** | Upload or pick from media library; falls back to CMS favicon |
| **Editor roles** | Restrict who can create/edit pages to specific admin roles |

### REST API for Headless Consumption

If you want to consume the content from a separate frontend (Next.js, mobile app, etc.), every page and the full tree are available as JSON:

| Endpoint | Description |
|---|---|
| `GET /api/v1/docs/tree` | Nested sidebar tree (collections → pages) |
| `GET /api/v1/docs/pages` | Flat list of all published pages (for search indexing) |
| `GET /api/v1/docs/pages/{slug}` | Full content + breadcrumb for a single page |

---

## Screenshots

<!-- SCREENSHOT: Admin — Doc Pages list view -->
> 📸 *Screenshot: Doc Pages list in Filament*

<!-- SCREENSHOT: Admin — Collections list view -->
> 📸 *Screenshot: Doc Collections list*

<!-- SCREENSHOT: Frontend — full page view, light mode, sidebar open -->
> 📸 *Screenshot: Frontend — light mode*

<!-- SCREENSHOT: Frontend — full page view, dark mode -->
> 📸 *Screenshot: Frontend — dark mode*

<!-- SCREENSHOT: Mobile view of frontend sidebar collapsed -->
> 📸 *Screenshot: Mobile view*

---

## Installation

### 1. Place the plugin

```
plugins-dev/magna/docs/
```

### 2. Register the path source in your root `composer.json`

```json
{
    "repositories": [
        { "type": "path", "url": "plugins-dev/magna/docs" }
    ]
}
```

### 3. Require the package

```bash
composer require magna/docs:@dev
```

### 4. Run migrations

```bash
php artisan migrate
```

### 5. Enable the plugin

Go to **Admin → Plugins** and enable **Magna Docs**.

---

## Usage

### Creating your first page

1. In the admin sidebar, navigate to **Magna Docs → Create Page**.
2. Type your title — the slug is auto-generated.
3. Write content in Markdown using the full-screen editor.
4. Optionally assign the page to a **Collection** and set a **parent page** for nesting.
5. Click **Publish page**. It's live at `/docs/{slug}` immediately.

### Organizing with Collections

1. Go to **Magna Docs → Collections** and create a collection (e.g. "Getting Started").
2. When creating/editing a page, pick the collection in the **Organisation** sidebar section.
3. Pages are grouped by collection in the public sidebar, ordered by the `order` field.

### Setting up branding

Go to **Magna Docs → Settings** and fill in your site name, logo, and favicon. These override the CMS defaults for the docs section only.

### Restricting editor access

In **Magna Docs → Settings**, under **Permissions**, select which admin roles are allowed to create and edit pages. Leave the field empty to allow all admin roles.

---

## Routes

| Route | Description |
|---|---|
| `GET /docs` | Landing page — redirects to the first published page |
| `GET /docs/{slug}` | Single doc page with sidebar, TOC, breadcrumb, SEO meta |
| `GET /docs/sitemap.xml` | Sitemap for all published pages |
| `GET /api/v1/docs/tree` | JSON — full nested sidebar tree |
| `GET /api/v1/docs/pages` | JSON — flat list of published pages |
| `GET /api/v1/docs/pages/{slug}` | JSON — single page content + breadcrumb |

---

## Data Model

```
doc_collections
  id, title, slug, description, icon, color, order, is_public

docs_pages
  id, collection_id, parent_id, title, slug
  excerpt, featured_image, show_featured_image
  meta_title, meta_description
  content (Markdown)
  status (draft|published|archived)
  order, is_published, published_at
```

---

## Requirements

- PHP 8.3+
- Laravel 11+
- Magna CMS (Filament 3-based)
- `league/commonmark` ^2.4 (installed automatically)

---

## License

MIT — see [LICENSE](LICENSE).
