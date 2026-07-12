@foreach($items as $item)
    <li>
        <a href="{{ route('docs.web.show', $item['slug']) }}"
           class="docs-nav-link {{ ($currentSlug === $item['slug']) ? 'active' : '' }}"
           @if($currentSlug === $item['slug']) aria-current="page" @endif>{{ $item['title'] }}</a>
        @if(!empty($item['children']))
            <ul class="ml-3 mt-1 space-y-1 border-l border-slate-100 dark:border-zinc-800 pl-1">
                @include('docs::partials.sidebar-links', ['items' => $item['children'], 'currentSlug' => $currentSlug])
            </ul>
        @endif
    </li>
@endforeach
