<!-- resources/views/petugas/menus/index.blade.php -->
@extends('layouts.app')

@section('title', 'Kelola Menu')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 sidebar">
            <div class="py-4">
                <h6 class="px-3 text-muted text-uppercase mb-3">Menu Navigasi</h6>
                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-2"></i>Dashboard
                    </a>
                    <a class="nav-link active" href="{{ route('petugas.menus.index') }}">
                        <i class="fas fa-utensils me-2"></i>Kelola Menu
                    </a>
                    <a class="nav-link" href="{{ route('petugas.toppings.index') }}">
                        <i class="fas fa-plus-circle me-2"></i>Kelola Topping
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold">Kelola Menu</h2>
                    <p class="text-muted mb-0">
                        <i class="fas fa-store me-1"></i>{{ auth()->user()->kantin->name ?? 'Kantin' }}
                    </p>
                </div>
                <a href="{{ route('petugas.menus.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Menu
                </a>
            </div>

            <!-- Search Bar -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('petugas.menus.index') }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari menu... (ketik minimal 2 karakter)" 
                                           value="{{ request('search') }}">
                                    <span class="input-group-text d-none" id="searchLoader">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </span>
                                    <button type="submit" class="btn btn-outline-secondary">Cari</button>
                                    @if(request('search'))
                                        <a href="{{ route('petugas.menus.index') }}" class="btn btn-outline-danger">Reset</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search Results Info -->
            @if(request('search'))
            <div class="alert alert-info">
                <i class="fas fa-search me-2"></i>
                Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                ({{ $menus->total() }} menu ditemukan)
            </div>
            @endif

            <!-- Menu Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" id="menuTableContainer">
                        @include('petugas.menus.partials.table', ['menus' => $menus])
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $menus->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let searchTimeout;

$(document).ready(function() {
    const searchLoader = $('#searchLoader');
    const searchResultsInfo = $('.alert-info');
    
    function performSearch(searchValue, page = 1) {
        searchLoader.removeClass('d-none');
        
        $.ajax({
            url: '{{ route("petugas.menus.index") }}',
            method: 'GET',
            data: {
                search: searchValue,
                page: page
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                // Update table content
                $('#menuTableContainer').html(response.html);
                
                // Update pagination
                $('.mt-4').html(response.pagination);
                
                // Update search results info
                if (searchValue && searchValue.length >= 2) {
                    const infoHtml = `
                        <div class="alert alert-info">
                            <i class="fas fa-search me-2"></i>
                            Menampilkan hasil pencarian untuk: <strong>"${searchValue}"</strong>
                            (${response.total} menu ditemukan)
                        </div>
                    `;
                    
                    if (searchResultsInfo.length) {
                        searchResultsInfo.replaceWith(infoHtml);
                    } else {
                        $('.card.mb-4').after(infoHtml);
                    }
                } else {
                    searchResultsInfo.remove();
                }
                
                // Update URL without refresh
                const newUrl = new URL(window.location.href);
                if (searchValue && searchValue.length >= 2) {
                    newUrl.searchParams.set('search', searchValue);
                } else {
                    newUrl.searchParams.delete('search');
                }
                if (page > 1) {
                    newUrl.searchParams.set('page', page);
                } else {
                    newUrl.searchParams.delete('page');
                }
                
                window.history.pushState({}, '', newUrl);
            },
            complete: function() {
                searchLoader.addClass('d-none');
            }
        });
    }
    
    // Live Search dengan debouncing
    $('input[name="search"]').on('input', function() {
        const searchValue = $(this).val();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Set new timeout untuk menghindari terlalu banyak request
        searchTimeout = setTimeout(function() {
            performSearch(searchValue);
        }, 500); // Delay 500ms untuk menghindari spam request
    });
    
    // Handle pagination clicks
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = new URL($(this).attr('href'));
        const page = url.searchParams.get('page') || 1;
        const search = $('input[name="search"]').val();
        
        performSearch(search, page);
    });
    
    // Auto focus pada search input dan set cursor di akhir
    const searchInput = $('input[name="search"]');
    if (searchInput.val()) {
        searchInput.focus();
        const val = searchInput.val();
        searchInput.val('').val(val); // Trick untuk set cursor di akhir
    }
});

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus menu ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush