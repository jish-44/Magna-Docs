<?php

declare(strict_types=1);

namespace Magna\Docs\Filament\Resources\DocPageResource\Pages;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Magna\Docs\Filament\Resources\DocPageResource;
use Magna\Docs\Models\DocCollection;
use Magna\Docs\Models\DocPage;
use Magna\Docs\Support\IngestsMedia;

class CreateDocPage extends CreateRecord
{
    use IngestsMedia;

    protected static string $resource = DocPageResource::class;

    protected string $view = 'docs::filament.doc-page-editor';

    public bool $isEditMode = false;

    public string $editorStatus = '';

    /** Path/URL of image chosen from the Magna media library (not via FileUpload). */
    public ?string $libraryImagePath = null;

    public ?string $libraryImageUrl = null;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->columns(1)
            ->components([
                TextInput::make('title')
                    ->hiddenLabel()
                    ->required()
                    ->placeholder('Add Title')
                    ->live(onBlur: true)
                    ->extraInputAttributes([
                        'class' => 'doc-editor-title-input',
                        'autocomplete' => 'off',
                    ])
                    ->afterStateUpdated(function (?string $state, callable $set, ?string $old, Get $get): void {
                        $currentSlug = $get('slug');
                        if (blank($currentSlug) || $currentSlug === Str::slug($old ?? '')) {
                            $set('slug', Str::slug($state ?? ''));
                        }
                    }),

                MarkdownEditor::make('content')
                    ->hiddenLabel()
                    ->toolbarButtons([
                        'bold', 'italic', 'strike', 'link',
                        'heading', 'bulletList', 'orderedList',
                        'blockquote', 'codeBlock', 'table',
                        'attachFiles', 'undo', 'redo',
                    ])
                    ->fileAttachmentsDirectory('docs-attachments')
                    ->extraAttributes(['class' => 'doc-editor-content']),
            ]);
    }

    public function sidebarForm(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Summary')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived (unpublished)',
                            ])
                            ->default('draft')
                            ->native(false)
                            ->selectablePlaceholder(false)
                            ->live(),

                        DateTimePicker::make('published_at')
                            ->label('Publish date')
                            ->visible(fn (Get $get): bool => $get('status') === 'published')
                            ->default(now()),

                        Placeholder::make('_visibility')
                            ->label('Visibility')
                            ->content('Public'),

                        Placeholder::make('_author')
                            ->label('Author')
                            ->content(fn (): string => auth()->user()?->name ?? 'Admin'),
                    ]),

                Section::make('Permalink')
                    ->collapsible()
                    ->schema([
                        TextInput::make('slug')
                            ->hiddenLabel()
                            ->required()
                            ->unique('docs_pages', 'slug', ignoreRecord: true)
                            ->placeholder('page-slug')
                            ->prefix('/docs/')
                            ->helperText('Auto-generated from the title — click to edit.'),
                    ]),

                Section::make('Featured Image')
                    ->collapsible()
                    ->schema([
                        FileUpload::make('featured_image')
                            ->hiddenLabel()
                            ->image()
                            ->disk('public')
                            ->directory('docs-featured')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('675')
                            ->panelAspectRatio('16:9')
                            ->panelLayout('integrated')
                            ->visible(fn (): bool => blank($this->libraryImageUrl)),

                        // When an image is chosen from the media library we render
                        // our own preview here (FilePond can't display a file it
                        // didn't upload), shown in place of the hidden dropzone.
                        Placeholder::make('_library_preview')
                            ->hiddenLabel()
                            ->visible(fn (): bool => filled($this->libraryImageUrl))
                            ->content(fn (): HtmlString => new HtmlString(
                                '<div class="de-featured-preview">'
                                .'<img src="'.e((string) $this->libraryImageUrl).'" alt="Featured image">'
                                .'<button type="button" class="de-featured-preview-remove" wire:click="clearLibraryImage" title="Remove image">&times;</button>'
                                .'<span class="de-featured-preview-tag">From media library</span>'
                                .'</div>'
                            )),

                        Placeholder::make('_browse_media')
                            ->hiddenLabel()
                            ->content(new HtmlString(
                                '<button type="button" class="de-browse-link" onclick="Livewire.dispatch(\'magna:open-media-picker\', { target: \'featured-image\' })">'
                                .'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>'
                                .'Browse media library</button>'
                            )),

                        Toggle::make('show_featured_image')
                            ->label('Show featured image on the page')
                            ->helperText('When on, the image appears below the title on the published page.')
                            ->default(true),
                    ]),

                Section::make('Organisation')
                    ->collapsible()
                    ->schema([
                        Select::make('collection_id')
                            ->label('Collection')
                            ->options(fn (): array => DocCollection::query()->orderBy('title')->pluck('title', 'id')->all())
                            ->searchable()
                            ->createOptionForm([
                                TextInput::make('title')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (?string $state, callable $set) => $set('slug', Str::slug($state ?? ''))),
                                TextInput::make('slug')
                                    ->required()
                                    ->unique('doc_collections', 'slug'),
                                Textarea::make('description')->rows(2),
                                Toggle::make('is_public')->default(true)->label('Publicly visible'),
                            ])
                            ->createOptionUsing(fn (array $data): int => DocCollection::create($data)->id)
                            ->placeholder('— uncategorised —'),

                        Select::make('parent_id')
                            ->label('Parent page')
                            ->options(fn (): array => DocPage::query()->orderBy('title')->pluck('title', 'id')->all())
                            ->searchable()
                            ->placeholder('— top level —'),

                        TextInput::make('order')
                            ->label('Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first in the sidebar.'),
                    ]),

                Section::make('SEO')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta title')
                            ->maxLength(70)
                            ->placeholder('Overrides page title in search results')
                            ->helperText('Recommended: 50–70 characters.'),

                        Textarea::make('meta_description')
                            ->label('Meta description')
                            ->rows(3)
                            ->maxLength(160)
                            ->placeholder('160-character summary for search results…')
                            ->helperText('Recommended: 120–160 characters.'),
                    ]),
            ]);
    }

    public function mount(): void
    {
        parent::mount();
    }

    #[On('magna:media-selected')]
    public function onMediaSelected(string $path, string $url, string $disk, string $target): void
    {
        if ($target === 'featured-image') {
            $this->selectMediaFile($path, $disk);
        }
    }

    /** Select an image from the Magna media library. */
    public function selectMediaFile(string $path, string $disk = 'public'): void
    {
        $this->libraryImagePath = $path;
        $this->libraryImageUrl = Storage::disk($disk)->url($path);
    }

    /** Clear a media-library selection and restore the upload dropzone. */
    public function clearLibraryImage(): void
    {
        $this->libraryImagePath = null;
        $this->libraryImageUrl = null;
    }

    public function saveDraft(): void
    {
        $this->data['status'] = 'draft';
        $this->create();
    }

    public function publish(): void
    {
        $this->data['status'] = 'published';
        $this->data['published_at'] ??= now()->toDateTimeString();
        $this->create();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $merged = array_merge($data, $this->sidebarForm->getState());
        $merged['order'] = (int) ($merged['order'] ?? 0);
        unset($merged['_visibility'], $merged['_author'], $merged['_status_display']);

        // FileUpload returns an array; DB expects a plain string path.
        if (is_array($merged['featured_image'] ?? null)) {
            $merged['featured_image'] = (string) (array_values(array_filter($merged['featured_image']))[0] ?? '');
        }

        // If nothing was uploaded via FileUpload but a media-library image was chosen, use it.
        if (empty($merged['featured_image']) && $this->libraryImagePath) {
            $merged['featured_image'] = $this->libraryImagePath;
        }

        // Register a freshly-uploaded featured image into the media library.
        if (! empty($merged['featured_image'])) {
            $merged['featured_image'] = $this->ingestToMedia((string) $merged['featured_image']) ?? $merged['featured_image'];
        }

        return $merged;
    }

    protected function getRedirectUrl(): string
    {
        return DocPageResource::getUrl('edit', ['record' => $this->record->getKey()]);
    }
}
