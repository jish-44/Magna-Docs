<x-filament-panels::page>
    <style>
        /* Browse-media link styled as a dashed pill, like the page editor. */
        .ds-browse-link {
            display: inline-flex !important; align-items: center; justify-content: center; gap: .4rem;
            width: 100%; padding: .5rem .75rem !important;
            border: 1px dashed rgb(203 213 225) !important; border-radius: 9px !important;
            background: transparent !important; box-shadow: none !important;
            color: rgb(139 92 246) !important; font-size: .8rem !important; font-weight: 500;
            transition: border-color .15s, background .15s;
        }
        .dark .ds-browse-link { border-color: rgb(63 63 70) !important; }
        .ds-browse-link:hover { border-color: rgb(139 92 246) !important; background: rgba(139,92,246,.05) !important; }
    </style>

    {{ $this->form }}

    {{-- Global media picker — opened by "Browse media library" buttons via magna:open-media-picker --}}
    <livewire:magna-media-picker />
</x-filament-panels::page>
