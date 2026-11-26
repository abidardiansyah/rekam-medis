@extends('layouts.app')

@section('title', 'Registrasi Pasien')

@section('content')
<div class="page-header">
  <div class="page-block">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item" aria-current="page">Registrasi</li>
    </ul>
    <div class="page-header-title">
      <h2 class="mb-0">Registrasi Pasien</h2>
    </div>
  </div>
</div>

<div class="grid grid-cols-12 gap-x-6">
  <div class="col-span-12">
    <div class="card table-card">
      <div class="card-header flex items-center justify-between">
        <h5>Daftar Registrasi</h5>
        <a href="{{ route('registrasi.create') }}" class="btn btn-primary">
          <i class="ti ti-plus"></i> Registrasi Baru
        </a>
      </div>
      <div class="card-body !pt-3">
        <div class="table-responsive" id="tableContainer">
          <table class="table table-hover" id="pc-dt-simple">
            <thead>
              <tr>
                <th>No. Registrasi</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Tanggal Kunjungan</th>
                <th>Jam</th>
                <th>Jenis</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              <tr>
                <th><input type="text" name="search_no_registrasi" placeholder="Cari no..." class="form-control form-control-sm" value="{{ request('search_no_registrasi') }}"></th>
                <th><input type="text" name="search_pasien" placeholder="Cari pasien..." class="form-control form-control-sm" value="{{ request('search_pasien') }}"></th>
                <th><input type="text" name="search_dokter" placeholder="Cari dokter..." class="form-control form-control-sm" value="{{ request('search_dokter') }}"></th>
                <th><input type="date" name="search_tanggal" class="form-control form-control-sm" value="{{ request('search_tanggal') }}"></th>
                <th></th>
                <th></th>
                <th>
                  <select name="search_status" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option value="menunggu" {{ request('search_status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="dipanggil" {{ request('search_status') == 'dipanggil' ? 'selected' : '' }}>Dipanggil</option>
                    <option value="selesai" {{ request('search_status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ request('search_status') == 'batal' ? 'selected' : '' }}>Batal</option>
                  </select>
                </th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse($registrasis as $registrasi)
              <tr>
                <td><strong>{{ $registrasi->no_registrasi }}</strong></td>
                <td>
                  <div class="flex items-center">
                    <div class="shrink-0 w-10">
                      <img src="{{ asset('assets/images/user/avatar-3.jpg') }}" alt="user image" class="rounded-full w-10" />
                    </div>
                    <div class="grow ltr:ml-3 rtl:mr-3">
                      <h6 class="mb-0">{{ $registrasi->pasien->nama }}</h6>
                      <small class="text-muted">{{ $registrasi->pasien->no_rm }}</small>
                    </div>
                  </div>
                </td>
                <td>
                  <div>
                    <h6 class="mb-0">{{ $registrasi->dokter->nama }}</h6>
                    <small class="text-muted">{{ $registrasi->dokter->spesialisasi }}</small>
                  </div>
                </td>
                <td>{{ \Carbon\Carbon::parse($registrasi->tanggal_kunjungan)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($registrasi->jam_kunjungan)->format('H:i') }}</td>
                <td>
                  @if($registrasi->jenis_kunjungan == 'baru')
                    <span class="badge bg-info-500/10 text-info-500">Baru</span>
                  @else
                    <span class="badge bg-warning-500/10 text-warning-500">Kontrol</span>
                  @endif
                </td>
                <td>
                  @if($registrasi->status == 'menunggu')
                    <span class="badge bg-secondary-500/10 text-secondary-500">Menunggu</span>
                  @elseif($registrasi->status == 'dipanggil')
                    <span class="badge bg-primary-500/10 text-primary-500">Dipanggil</span>
                  @elseif($registrasi->status == 'selesai')
                    <span class="badge bg-success-500/10 text-success-500">Selesai</span>
                  @else
                    <span class="badge bg-danger-500/10 text-danger-500">Batal</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('registrasi.edit', $registrasi->id) }}" class="avtar avtar-xs btn-link-secondary">
                    <i class="ti ti-edit text-xl leading-none"></i>
                  </a>
                  <form action="{{ route('registrasi.destroy', $registrasi->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus registrasi ini?')">
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
                <td colspan="8" class="text-center">Belum ada data registrasi</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div id="paginationContainer">
        @if($registrasis->hasPages())
        <div class="mt-4 flex justify-end pr-4">
          <nav aria-label="Page navigation">
            <ul class="flex *:*:inline-block *:*:px-3 *:*:py-1.5 *:border *:border-theme-border *:dark:border-themedark-border hover:*:bg-secondary-300/10">
              @if($registrasis->onFirstPage())
                <li class="ltr:rounded-l-lg rtl:rounded-r-lg select-none !bg-secondary-500/10"><span>Previous</span></li>
              @else
                <li class="ltr:rounded-l-lg rtl:rounded-r-lg"><a href="{{ $registrasis->previousPageUrl() }}">Previous</a></li>
              @endif
              
              @foreach($registrasis->getUrlRange(1, $registrasis->lastPage()) as $page => $url)
                @if($page == $registrasis->currentPage())
                  <li class="!bg-primary-500 !text-white !border-primary-500"><span>{{ $page }}</span></li>
                @else
                  <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
              @endforeach
              
              @if($registrasis->hasMorePages())
                <li class="ltr:rounded-r-lg rtl:rounded-l-lg"><a href="{{ $registrasis->nextPageUrl() }}">Next</a></li>
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
    
    fetch('{{ route("registrasi.index") }}?' + formData.toString(), {
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
