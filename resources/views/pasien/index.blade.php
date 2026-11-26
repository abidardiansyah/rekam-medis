@extends('layouts.app')

@section('title', 'Data Pasien')

@section('content')
<div class="page-header">
  <div class="page-block">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="javascript: void(0)">Master Data</a></li>
      <li class="breadcrumb-item" aria-current="page">Pasien</li>
    </ul>
    <div class="page-header-title">
      <h2 class="mb-0">Data Pasien</h2>
    </div>
  </div>
</div>

<div class="grid grid-cols-12 gap-x-6">
  <div class="col-span-12">
    <div class="card table-card">
      <div class="card-header flex items-center justify-between">
        <h5>Daftar Pasien</h5>
        <a href="{{ route('pasien.create') }}" class="btn btn-primary">
          <i class="ti ti-plus"></i> Tambah Pasien
        </a>
      </div>
      <div class="card-body !pt-3">
        <div class="table-responsive" id="tableContainer">
          <table class="table table-hover" id="pc-dt-simple">
            <thead>
              <tr>
                <th>Nama</th>
                <th>No. RM</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Telepon</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              <tr>
                <th><input type="text" name="search_nama" placeholder="Cari nama..." class="form-control form-control-sm" value="{{ request('search_nama') }}"></th>
                <th><input type="text" name="search_no_rm" placeholder="Cari No. RM..." class="form-control form-control-sm" value="{{ request('search_no_rm') }}"></th>
                <th>
                  <select name="search_jenis_kelamin" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option value="L" {{ request('search_jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('search_jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                  </select>
                </th>
                <th></th>
                <th><input type="text" name="search_telepon" placeholder="Cari telepon..." class="form-control form-control-sm" value="{{ request('search_telepon') }}"></th>
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
              @forelse($pasiens as $pasien)
              <tr>
                <td>
                  <div class="flex items-center">
                    <div class="shrink-0 w-10">
                      <img src="{{ asset('assets/images/user/avatar-3.jpg') }}" alt="user image" class="rounded-full w-10" />
                    </div>
                    <div class="grow ltr:ml-3 rtl:mr-3">
                      <h6 class="mb-0">{{ $pasien->nama }}</h6>
                      <small class="text-muted">{{ $pasien->email ?? '-' }}</small>
                    </div>
                  </div>
                </td>
                <td>{{ $pasien->no_rm }}</td>
                <td>{{ $pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d/m/Y') }}</td>
                <td>{{ $pasien->telepon }}</td>
                <td>
                  @if($pasien->status == 'aktif')
                    <span class="text-success-500"><i class="fas fa-circle text-[10px] mr-2.5"></i> Aktif</span>
                  @else
                    <span class="text-secondary-500"><i class="fas fa-circle text-[10px] mr-2.5"></i> Nonaktif</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('pasien.show', $pasien->id) }}" class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary">
                    <i class="ti ti-eye text-xl leading-none"></i>
                  </a>
                  <a href="{{ route('pasien.edit', $pasien->id) }}" class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary">
                    <i class="ti ti-edit text-xl leading-none"></i>
                  </a>
                  <form action="{{ route('pasien.destroy', $pasien->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                <td colspan="7" class="text-center">Belum ada data pasien</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div id="paginationContainer">
        @if($pasiens->hasPages())
        <div class="mt-4 flex justify-end pr-4">
          <nav aria-label="Page navigation">
            <ul class="flex *:*:inline-block *:*:px-3 *:*:py-1.5 *:border *:border-theme-border *:dark:border-themedark-border hover:*:bg-secondary-300/10">
              @if($pasiens->onFirstPage())
                <li class="ltr:rounded-l-lg rtl:rounded-r-lg select-none !bg-secondary-500/10"><span>Previous</span></li>
              @else
                <li class="ltr:rounded-l-lg rtl:rounded-r-lg"><a href="{{ $pasiens->previousPageUrl() }}">Previous</a></li>
              @endif
              
              @foreach($pasiens->getUrlRange(1, $pasiens->lastPage()) as $page => $url)
                @if($page == $pasiens->currentPage())
                  <li class="!bg-primary-500 !text-white !border-primary-500"><span>{{ $page }}</span></li>
                @else
                  <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
              @endforeach
              
              @if($pasiens->hasMorePages())
                <li class="ltr:rounded-r-lg rtl:rounded-l-lg"><a href="{{ $pasiens->nextPageUrl() }}">Next</a></li>
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
    
    fetch('{{ route("pasien.index") }}?' + formData.toString(), {
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
