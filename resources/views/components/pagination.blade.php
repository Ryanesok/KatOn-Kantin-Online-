@props(['paginator'])

@if ($paginator->hasPages())
    <nav class="flex items-center justify-between gap-4 mt-4">

        {{-- Tombol Back --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 text-gray-400">‹ Back</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 hover:underline">‹ Back</a>
        @endif

        {{-- Halaman --}}
        <div class="flex items-center gap-2">
            {{-- First Page --}}
            @if ($paginator->currentPage() > 3)
                <a href="{{ $paginator->url(1) }}" class="px-3 py-1 hover:underline">1</a>
                @if ($paginator->currentPage() > 4)
                    <span class="px-2">…</span>
                @endif
            @endif

            {{-- Pages Around Current --}}
            @for ($i = max(1, $paginator->currentPage() - 2); $i <= min($paginator->lastPage(), $paginator->currentPage() + 2); $i++)
                @if ($i == $paginator->currentPage())
                    <span class="px-3 py-1 font-bold bg-black text-white rounded">{{ $i }}</span>
                @else
                    <a href="{{ $paginator->url($i) }}" class="px-3 py-1 hover:underline">{{ $i }}</a>
                @endif
            @endfor

            {{-- Last Page --}}
            @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                    <span class="px-2">…</span>
                @endif
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="px-3 py-1 hover:underline">{{ $paginator->lastPage() }}</a>
            @endif
        </div>

        {{-- Tombol Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 hover:underline">Next ›</a>
        @else
            <span class="px-3 py-1 text-gray-400">Next ›</span>
        @endif
    </nav>

    {{-- Info + Dropdown per page --}}
    <div class="flex items-center justify-between mt-2 text-sm text-gray-600">
        <span>
            {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} of {{ $paginator->total() }}
        </span>
        <form method="GET">
            <label>
                Result per page
                <select name="per_page" onchange="this.form.submit()" class="border rounded px-2 py-1">
                    @foreach([5, 10, 20, 50] as $size)
                        <option value="{{ $size }}" {{ request('per_page', $paginator->perPage()) == $size ? 'selected' : '' }}>
                            {{ $size }}
                        </option>
                    @endforeach
                </select>
            </label>
            @foreach(request()->except('per_page', 'page') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
        </form>
    </div>
@endif
