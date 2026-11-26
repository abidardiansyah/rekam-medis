@extends('layouts.app')

@section('title', 'Data Perawat')

@section('content')
<div class="page-header">
  <div class="page-block">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="javascript: void(0)">Master Data</a></li>
      <li class="breadcrumb-item" aria-current="page">Perawat</li>
    </ul>
    <div class="page-header-title">
      <h2 class="mb-0">Data Perawat</h2>
    </div>
  </div>
</div>

<div class="grid grid-cols-12 gap-x-6">
  <div class="col-span-12">
    <div class="card table-card">
      <div class="card-header flex items-center justify-between">
        <h5>Daftar Perawat</h5>
        <a href="{{ route('perawat.create') }}" class="btn btn-primary">
          <i class="ti ti-plus"></i> Tambah Perawat
        </a>
      </div>
      <div class="card-body !pt-3">
        <div class="table-responsive" id="tableContainer">
          <table class="table table-hover" id="pc-dt-simple">
            <thead>
              <tr>
                <th>Nama</th>
                <th>No. STR</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              <tr>
                <th><input type="text" name="search_nama" placeholder="Cari nama..." class="form-control form-control-sm" value="{{ request('search_nama') }}"></th>
                <th><input type="text" name="search_no_str" placeholder="Cari No. STR..." class="form-control form-control-sm" value="{{ request('search_no_str') }}"></th>
                <th><input type="text" name="search_telepon" placeholder="Cari telepon..." class="form-control form-control-sm" value="{{ request('search_telepon') }}"></th>
                <th><input type="text" name="search_email" placeholder="Cari email..." class="form-control form-control-sm" value="{{ request('search_email') }}"></th>
                <th>
                  <select name="search_status" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option value="aktif" {{ request('search_status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('search_status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                  </select>
                </th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse($perawats as $perawat)
              <tr>
                <td>
                  <div class="flex items-center">
                    <div class="shrink-0 w-10">
                      <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="user image" class="rounded-full w-10" />
                    </div>
                    <div class="grow ltr:ml-3 rtl:mr-3">
                      <h6 class="mb-0">{{ $perawat->nama }}</h6>
                    </div>
                  </div>
                </td>
                <td>{{ $perawat->no_str }}</td>
                <td>{{ $perawat->telepon }}</td>
                <td>{{ $perawat->email ?? '-' }}</td>
                <td>
                  @if($perawat->status == 'aktif')
                    <span class="text-success-500"><i class="fas fa-circle text-[10px] mr-2.5"></i> Aktif</span>
                  @else
                    <span class="text-secondary-500"><i class="fas fa-circle text-[10px] mr-2.5"></i> Nonaktif</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('perawat.show', $perawat->id) }}" class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary">
                    <i class="ti ti-eye text-xl leading-none"></i>
                  </a>
                  <a href="{{ route('perawat.edit', $perawat->id) }}" class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary">
                    <i class="ti ti-edit text-xl leading-none"></i>
                  </a>
                  <form action="{{ route('perawat.destroy', $perawat->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary">
                      <i class="ti ti-trash text-xl leading-none"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center">Belum ada data perawat</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div id="paginationContainer">
        @if($perawats->hasPages())
        <div class="mt-4 flex justify-end pr-4">
          <nav aria-label="Page navigation">
            <ul class="flex *:*:inline-block *:*:px-3 *:*:py-1.5 *:border *:border-theme-border *:dark:border-themedark-border hover:*:bg-secondary-300/10">
              @if($perawats->onFirstPage())
                <li class="ltr:rounded-l-lg rtl:rounded-r-lg select-none !bg-secondary-500/10"><span>Previous</span></li>
              @else
                <li class="ltr:rounded-l-lg rtl:rounded-r-lg"><a href="{{ $perawats->previousPageUrl() }}">Previous</a></li>
              @endif
              
              @foreach($perawats->getUrlRange(1, $perawats->lastPage()) as $page => $url)
                @if($page == $perawats->currentPage())
                  <li class="!bg-primary-500 !text-white !border-primary-500"><span>{{ $page }}</span></li>
                @else
                  <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
              @endforeach
              
              @if($perawats->hasMorePages())
                <li class="ltr:rounded-r-lg rtl:rounded-l-lg"><a href="{{ $perawats->nextPageUrl() }}">Next</a></li>
              @else
                <li class="ltr:rounded-r-lg rtl:rounded-l-lg select-none !bg-secondary-500/10"><span>Next</span></li>
              @endif
            </ul>
          </nav>
        </div>
        @endif
        </div>
      </div>
    </div>
  </div>
</div>

<script>
let searchTimeout;
document.addEventListener('DOMContentLoaded', function() {
    attachSearchListeners();
});

function attachSearchListeners() {
    document.querySelectorAll('input[name^="search_"], select[name^="search_"]').forEach(element => {
        element.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch();
            }, 300);
        });
    });
}

function performSearch(page = 1) {
    // Save current focus
    const activeElement = document.activeElement;
    const focusName = activeElement ? activeElement.name : null;
    const cursorPosition = activeElement && activeElement.selectionStart ? activeElement.selectionStart : null;
    
    const formData = new URLSearchParams();
    document.querySelectorAll('input[name^="search_"], select[name^="search_"]').forEach(element => {
        if (element.value) {
            formData.append(element.name, element.value);
        }
    });
    formData.append('page', page);
    
    fetch('{{ route("perawat.index") }}?' + formData.toString(), {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        document.getElementById('tableContainer').innerHTML = doc.getElementById('tableContainer').innerHTML;
        document.getElementById('paginationContainer').innerHTML = doc.getElementById('paginationContainer').innerHTML;
        
        attachSearchListeners();
        attachPaginationListeners();
        
        // Restore focus
        if (focusName) {
            const elementToFocus = document.querySelector(`[name="${focusName}"]`);
            if (elementToFocus) {
                elementToFocus.focus();
                if (cursorPosition !== null && elementToFocus.setSelectionRange) {
                    elementToFocus.setSelectionRange(cursorPosition, cursorPosition);
                }
            }
        }
    });
}

function attachPaginationListeners() {
    document.querySelectorAll('#paginationContainer a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            performSearch(page);
        });
    });
}
</script>
@endsection
