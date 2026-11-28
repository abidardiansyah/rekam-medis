@extends('layouts.app')

@section('title', 'Data Obat')

@section('content')
<div class="page-header">
  <div class="page-block">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="javascript: void(0)">Master Data</a></li>
      <li class="breadcrumb-item" aria-current="page">Obat</li>
    </ul>
    <div class="page-header-title">
      <h2 class="mb-0">Data Obat</h2>
    </div>
  </div>
</div>

<div class="grid grid-cols-12 gap-x-6">
  <div class="col-span-12">
    <div class="card table-card">
      <div class="card-header flex items-center justify-between">
        <h5>Daftar Obat</h5>
        <button type="button" class="btn btn-primary" data-pc-toggle="modal" data-pc-target="#createModal">
          <i class="ti ti-plus"></i> Tambah Obat
        </button>
      </div>
      <div class="card-body !pt-3">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="table-responsive" id="tableContainer">
          <table class="table table-hover" id="pc-dt-simple">
            <thead>
              <tr>
                <th>Kode Obat</th>
                <th>Nama Obat</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              <tr>
                <th><input type="text" name="search_kode_obat" placeholder="Cari kode..." class="form-control form-control-sm" value="{{ request('search_kode_obat') }}"></th>
                <th><input type="text" name="search_nama_obat" placeholder="Cari nama..." class="form-control form-control-sm" value="{{ request('search_nama_obat') }}"></th>
                <th><input type="text" name="search_kategori" placeholder="Cari kategori..." class="form-control form-control-sm" value="{{ request('search_kategori') }}"></th>
                <th></th>
                <th></th>
                <th>
                  <select name="search_status" class="form-select form-select-sm">
                    <option value="">Semua</option>
                    <option value="tersedia" {{ request('search_status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="habis" {{ request('search_status') == 'habis' ? 'selected' : '' }}>Habis</option>
                    <option value="kadaluarsa" {{ request('search_status') == 'kadaluarsa' ? 'selected' : '' }}>Kadaluarsa</option>
                  </select>
                </th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse($apoteks as $apotek)
              <tr>
                <td><code>{{ $apotek->kode_obat }}</code></td>
                <td>{{ $apotek->nama_obat }}</td>
                <td>{{ $apotek->kategori }}</td>
                <td>{{ $apotek->satuan }}</td>
                <td>{{ $apotek->stok }}</td>
                <td>
                  @if($apotek->status === 'tersedia')
                    <span class="text-success-500"><i class="fas fa-circle text-[10px] mr-2.5"></i> Tersedia</span>
                  @elseif($apotek->status === 'habis')
                    <span class="text-danger-500"><i class="fas fa-circle text-[10px] mr-2.5"></i> Habis</span>
                  @else
                    <span class="text-warning-500"><i class="fas fa-circle text-[10px] mr-2.5"></i> Kadaluarsa</span>
                  @endif
                </td>
                <td>
                  <button type="button" class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary" data-pc-toggle="modal" data-pc-target="#viewModal{{ $apotek->id }}">
                    <i class="ti ti-eye text-xl leading-none"></i>
                  </button>
                  <button type="button" class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary" data-pc-toggle="modal" data-pc-target="#editModal{{ $apotek->id }}">
                    <i class="ti ti-edit text-xl leading-none"></i>
                  </button>
                  <form action="{{ route('apotek.destroy', $apotek) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                <td colspan="7" class="text-center">Tidak ada data</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div id="paginationContainer">
        @if($apoteks->hasPages())
        <div class="mt-4 flex justify-end pr-4">
          <nav aria-label="Page navigation">
            <ul class="flex *:*:inline-block *:*:px-3 *:*:py-1.5 *:border *:border-theme-border *:dark:border-themedark-border hover:*:bg-secondary-300/10">
              @if($apoteks->onFirstPage())
                <li class="ltr:rounded-l-lg rtl:rounded-r-lg select-none !bg-secondary-500/10"><span>Previous</span></li>
              @else
                <li class="ltr:rounded-l-lg rtl:rounded-r-lg"><a href="{{ $apoteks->previousPageUrl() }}">Previous</a></li>
              @endif
              
              @foreach($apoteks->getUrlRange(1, $apoteks->lastPage()) as $page => $url)
                @if($page == $apoteks->currentPage())
                  <li class="!bg-primary-500 !text-white !border-primary-500"><span>{{ $page }}</span></li>
                @else
                  <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
              @endforeach
              
              @if($apoteks->hasMorePages())
                <li class="ltr:rounded-r-lg rtl:rounded-l-lg"><a href="{{ $apoteks->nextPageUrl() }}">Next</a></li>
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

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true" data-pc-modal-show="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Obat</h5>
        <button type="button" class="btn-close" data-pc-modal-dismiss="#createModal"></button>
      </div>
      <form action="{{ route('apotek.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Kode Obat <span class="text-danger">*</span></label>
            <input type="text" name="kode_obat" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
            <input type="text" name="nama_obat" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Kategori <span class="text-danger">*</span></label>
            <input type="text" name="kategori" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Satuan <span class="text-danger">*</span></label>
            <input type="text" name="satuan" class="form-control" placeholder="Tablet, Kapsul, Botol, dll" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Stok <span class="text-danger">*</span></label>
            <input type="number" name="stok" class="form-control" min="0" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Harga <span class="text-danger">*</span></label>
            <input type="number" name="harga" class="form-control" min="0" step="0.01" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Tanggal Kadaluarsa</label>
            <input type="date" name="tanggal_kadaluarsa" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-select" required>
              <option value="tersedia">Tersedia</option>
              <option value="habis">Habis</option>
              <option value="kadaluarsa">Kadaluarsa</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-pc-modal-dismiss="#createModal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- View Modals -->
@foreach($apoteks as $apotek)
<div class="modal fade" id="viewModal{{ $apotek->id }}" tabindex="-1" aria-hidden="true" data-pc-modal-show="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Obat</h5>
        <button type="button" class="btn-close" data-pc-modal-dismiss="#viewModal{{ $apotek->id }}"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label fw-bold">Kode Obat</label>
          <p>{{ $apotek->kode_obat }}</p>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Nama Obat</label>
          <p>{{ $apotek->nama_obat }}</p>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Kategori</label>
          <p>{{ $apotek->kategori }}</p>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Satuan</label>
          <p>{{ $apotek->satuan }}</p>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Stok</label>
          <p>{{ $apotek->stok }}</p>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Harga</label>
          <p>Rp {{ number_format($apotek->harga, 0, ',', '.') }}</p>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Tanggal Kadaluarsa</label>
          <p>{{ $apotek->tanggal_kadaluarsa ? $apotek->tanggal_kadaluarsa->format('d/m/Y') : '-' }}</p>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Deskripsi</label>
          <p>{{ $apotek->deskripsi ?? '-' }}</p>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Status</label>
          <p>
            @if($apotek->status === 'tersedia')
              <span class="badge bg-success">Tersedia</span>
            @elseif($apotek->status === 'habis')
              <span class="badge bg-danger">Habis</span>
            @else
              <span class="badge bg-warning">Kadaluarsa</span>
            @endif
          </p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-pc-modal-dismiss="#viewModal{{ $apotek->id }}">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $apotek->id }}" tabindex="-1" aria-hidden="true" data-pc-modal-show="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Obat</h5>
        <button type="button" class="btn-close" data-pc-modal-dismiss="#editModal{{ $apotek->id }}"></button>
      </div>
      <form action="{{ route('apotek.update', $apotek) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Kode Obat <span class="text-danger">*</span></label>
            <input type="text" name="kode_obat" class="form-control" value="{{ $apotek->kode_obat }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
            <input type="text" name="nama_obat" class="form-control" value="{{ $apotek->nama_obat }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Kategori <span class="text-danger">*</span></label>
            <input type="text" name="kategori" class="form-control" value="{{ $apotek->kategori }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Satuan <span class="text-danger">*</span></label>
            <input type="text" name="satuan" class="form-control" value="{{ $apotek->satuan }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Stok <span class="text-danger">*</span></label>
            <input type="number" name="stok" class="form-control" value="{{ $apotek->stok }}" min="0" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Harga <span class="text-danger">*</span></label>
            <input type="number" name="harga" class="form-control" value="{{ $apotek->harga }}" min="0" step="0.01" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Tanggal Kadaluarsa</label>
            <input type="date" name="tanggal_kadaluarsa" class="form-control" value="{{ $apotek->tanggal_kadaluarsa?->format('Y-m-d') }}">
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ $apotek->deskripsi }}</textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-select" required>
              <option value="tersedia" {{ $apotek->status === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
              <option value="habis" {{ $apotek->status === 'habis' ? 'selected' : '' }}>Habis</option>
              <option value="kadaluarsa" {{ $apotek->status === 'kadaluarsa' ? 'selected' : '' }}>Kadaluarsa</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-pc-modal-dismiss="#editModal{{ $apotek->id }}">Batal</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function() {
    attachSearchListeners();
    attachPaginationListeners();
});

function attachSearchListeners() {
    document.querySelectorAll('input[name^="search_"], select[name^="search_"]').forEach(element => {
        element.addEventListener('input', debounce(function() {
            performSearch();
        }, 500));
        
        element.addEventListener('change', function() {
            performSearch();
        });
    });
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function performSearch(page = 1) {
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
    
    fetch('{{ route("apotek.index") }}?' + formData.toString(), {
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
