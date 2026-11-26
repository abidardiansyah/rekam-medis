@extends('layouts.app')

@section('title', 'Jadwal Dokter')

@section('content')
<div class="page-header">
  <div class="page-block">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="javascript: void(0)">Master Data</a></li>
      <li class="breadcrumb-item" aria-current="page">Jadwal Dokter</li>
    </ul>
    <div class="page-header-title">
      <h2 class="mb-0">Jadwal Dokter</h2>
    </div>
  </div>
</div>

<div class="grid grid-cols-12 gap-x-6">
  <div class="col-span-12">
    <div class="card table-card">
      <div class="card-header flex items-center justify-between">
        <h5>Daftar Jadwal Dokter</h5>
        <a href="{{ route('jadwal-dokter.create') }}" class="btn btn-primary">
          <i class="ti ti-plus"></i> Tambah Jadwal
        </a>
      </div>
      <div class="card-body !pt-3">
        <div class="table-responsive" id="tableContainer">
          <table class="table table-hover" id="pc-dt-simple">
            <thead>
              <tr>
                <th>Dokter</th>
                <th>Hari</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Ruangan</th>
                <th>Kuota</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              <tr>
                <th><input type="text" name="search_dokter" placeholder="Cari dokter..." class="form-control form-control-sm" value="{{ request('search_dokter') }}"></th>
                <th><input type="text" name="search_hari" placeholder="Cari hari..." class="form-control form-control-sm" value="{{ request('search_hari') }}"></th>
                <th></th>
                <th></th>
                <th><input type="text" name="search_ruangan" placeholder="Cari ruangan..." class="form-control form-control-sm" value="{{ request('search_ruangan') }}"></th>
                <th></th>
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
              @forelse($jadwals as $jadwal)
              <tr>
                <td>
                  <div class="flex items-center">
                    <div class="shrink-0 w-10">
                      <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="user image" class="rounded-full w-10" />
                    </div>
                    <div class="grow ltr:ml-3 rtl:mr-3">
                      <h6 class="mb-0">{{ $jadwal->dokter->nama }}</h6>
                      <small class="text-muted">{{ $jadwal->dokter->spesialisasi }}</small>
                    </div>
                  </div>
                </td>
                <td>{{ $jadwal->hari }}</td>
                <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                <td>{{ $jadwal->ruangan ?? '-' }}</td>
                <td>{{ $jadwal->kuota }}</td>
                <td>
                  @if($jadwal->status == 'aktif')
                    <span class="badge bg-success-500/10 text-success-500">Aktif</span>
                  @else
                    <span class="badge bg-danger-500/10 text-danger-500">Nonaktif</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('jadwal-dokter.edit', $jadwal->id) }}" class="avtar avtar-xs btn-link-secondary">
                    <i class="ti ti-edit text-xl leading-none"></i>
                  </a>
                  <form action="{{ route('jadwal-dokter.destroy', $jadwal->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="avtar avtar-xs btn-link-secondary">
                      <i class="ti ti-trash text-xl leading-none"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="8" class="text-center">Belum ada data jadwal dokter</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div id="paginationContainer">
        @if($jadwals->hasPages())
        <div class="mt-4 flex justify-end pr-4">
          <nav aria-label="Page navigation">
            <ul class="flex *:*:inline-block *:*:px-3 *:*:py-1.5 *:border *:border-theme-border *:dark:border-themedark-border hover:*:bg-secondary-300/10">
              @if($jadwals->onFirstPage())
                <li class="ltr:rounded-l-lg rtl:rounded-r-lg select-none !bg-secondary-500/10"><span>Previous</span></li>
              @else
                <li class="ltr:rounded-l-lg rtl:rounded-r-lg"><a href="{{ $jadwals->previousPageUrl() }}">Previous</a></li>
              @endif
              
              @foreach($jadwals->getUrlRange(1, $jadwals->lastPage()) as $page => $url)
                @if($page == $jadwals->currentPage())
                  <li class="!bg-primary-500 !text-white !border-primary-500"><span>{{ $page }}</span></li>
                @else
                  <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
              @endforeach
              
              @if($jadwals->hasMorePages())
                <li class="ltr:rounded-r-lg rtl:rounded-l-lg"><a href="{{ $jadwals->nextPageUrl() }}">Next</a></li>
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
    
    fetch('{{ route("jadwal-dokter.index") }}?' + formData.toString(), {
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
