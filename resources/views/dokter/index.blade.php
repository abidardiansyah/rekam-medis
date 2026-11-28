@extends('layouts.app')

@section('title', 'Data Dokter')

@section('content')
<div class="page-header">
  <div class="page-block">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="javascript: void(0)">Master Data</a></li>
      <li class="breadcrumb-item" aria-current="page">Dokter</li>
    </ul>
    <div class="page-header-title">
      <h2 class="mb-0">Data Dokter</h2>
    </div>
  </div>
</div>

<div class="grid grid-cols-12 gap-x-6">
  <div class="col-span-12">
    <div class="card table-card">
      <div class="card-header flex items-center justify-between">
        <h5>Daftar Dokter</h5>
        <button type="button" class="btn btn-primary" data-pc-toggle="modal" data-pc-target="#createModal">
          <i class="ti ti-plus"></i> Tambah Dokter
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
                <th>Nama</th>
                <th>Spesialisasi</th>
                <th>No. SIP</th>
                <th>Telepon</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              <tr>
                <th><input type="text" name="search_nama" placeholder="Cari nama..." class="form-control form-control-sm" value="{{ request('search_nama') }}"></th>
                <th><input type="text" name="search_spesialisasi" placeholder="Cari spesialisasi..." class="form-control form-control-sm" value="{{ request('search_spesialisasi') }}"></th>
                <th><input type="text" name="search_no_sip" placeholder="Cari No. SIP..." class="form-control form-control-sm" value="{{ request('search_no_sip') }}"></th>
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
              @forelse($dokters as $dokter)
              <tr>
                <td>
                  <div class="flex items-center">
                    <div class="shrink-0 w-10">
                      @php
                        $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($dokter->nama) . '&background=4F46E5&color=fff&size=80';
                        if ($dokter->foto) {
                          if (filter_var($dokter->foto, FILTER_VALIDATE_URL)) {
                            $avatarUrl = $dokter->foto;
                          } else {
                            $avatarUrl = asset('storage/' . $dokter->foto);
                          }
                        }
                      @endphp
                      <img src="{{ $avatarUrl }}" alt="user image" class="rounded-full w-10" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($dokter->nama) }}&background=4F46E5&color=fff&size=80'" />
                    </div>
                    <div class="grow ltr:ml-3 rtl:mr-3">
                      <h6 class="mb-0">{{ $dokter->nama }}</h6>
                      <small class="text-muted">{{ $dokter->email }}</small>
                    </div>
                  </div>
                </td>
                <td>{{ $dokter->spesialisasi }}</td>
                <td><code>{{ $dokter->no_sip }}</code></td>
                <td>{{ $dokter->telepon }}</td>
                <td>
                  @if($dokter->status === 'aktif')
                    <span class="text-success-500"><i class="fas fa-circle text-[10px] mr-2.5"></i> Aktif</span>
                  @else
                    <span class="text-secondary-500"><i class="fas fa-circle text-[10px] mr-2.5"></i> Nonaktif</span>
                  @endif
                </td>
                <td>
                  <button type="button" class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary" data-pc-toggle="modal" data-pc-target="#viewModal{{ $dokter->id }}">
                    <i class="ti ti-eye text-xl leading-none"></i>
                  </button>
                  <button type="button" class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary" data-pc-toggle="modal" data-pc-target="#editModal{{ $dokter->id }}">
                    <i class="ti ti-edit text-xl leading-none"></i>
                  </button>
                  <form action="{{ route('dokter.destroy', $dokter) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                <td colspan="6" class="text-center">Belum ada data dokter</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div id="paginationContainer">
        @if($dokters->hasPages())
        <div class="mt-4 flex justify-end pr-4">
          <nav aria-label="Page navigation">
            <ul class="flex *:*:inline-block *:*:px-3 *:*:py-1.5 *:border *:border-theme-border *:dark:border-themedark-border hover:*:bg-secondary-300/10">
              @if($dokters->onFirstPage())
                <li class="ltr:rounded-l-lg rtl:rounded-r-lg select-none !bg-secondary-500/10"><span>Previous</span></li>
              @else
                <li class="ltr:rounded-l-lg rtl:rounded-r-lg"><a href="{{ $dokters->previousPageUrl() }}">Previous</a></li>
              @endif
              
              @foreach($dokters->getUrlRange(1, $dokters->lastPage()) as $page => $url)
                @if($page == $dokters->currentPage())
                  <li class="!bg-primary-500 !text-white !border-primary-500"><span>{{ $page }}</span></li>
                @else
                  <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
              @endforeach
              
              @if($dokters->hasMorePages())
                <li class="ltr:rounded-r-lg rtl:rounded-l-lg"><a href="{{ $dokters->nextPageUrl() }}">Next</a></li>
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
  <div class="modal-dialog modal-dialog-centered" style="max-width: 880px;">
    <div class="modal-content">
      <div class="modal-header" style="padding: 18px 24px; border-bottom: 1px solid #E5E7EB;">
        <h5 class="modal-title" style="font-size: 18px; font-weight: 600; margin: 0;">Tambah Dokter</h5>
        <button type="button" class="btn-close" data-pc-modal-dismiss="#createModal" aria-label="Close"></button>
      </div>
      <form action="{{ route('dokter.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body" style="padding: 24px; max-height: 85vh; overflow-y: auto;">
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <div>
              <div style="margin-bottom: 14px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Nama <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control" style="border: none; border-bottom: 1px solid #E5E7EB; border-radius: 0; padding: 8px 0; height: 40px; font-size: 14px;" required>
              </div>
              <div style="margin-bottom: 14px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Spesialisasi <span class="text-danger">*</span></label>
                <input type="text" name="spesialisasi" class="form-control" style="border: none; border-bottom: 1px solid #E5E7EB; border-radius: 0; padding: 8px 0; height: 40px; font-size: 14px;" required>
              </div>
              <div style="margin-bottom: 14px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">No. SIP <span class="text-danger">*</span></label>
                <input type="text" name="no_sip" class="form-control" style="border: none; border-bottom: 1px solid #E5E7EB; border-radius: 0; padding: 8px 0; height: 40px; font-size: 14px;" required>
              </div>
              <div style="margin-bottom: 0;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" style="border: none; border-bottom: 1px solid #E5E7EB; border-radius: 0; padding: 8px 0; height: 40px; font-size: 14px;" required>
              </div>
            </div>
            <div>
              <div style="margin-bottom: 14px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Telepon <span class="text-danger">*</span></label>
                <input type="text" name="telepon" class="form-control" style="border: none; border-bottom: 1px solid #E5E7EB; border-radius: 0; padding: 8px 0; height: 40px; font-size: 14px;" required>
              </div>
              <div style="margin-bottom: 14px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Alamat</label>
                <textarea name="alamat" class="form-control" style="border: none; border-bottom: 1px solid #E5E7EB; border-radius: 0; padding: 8px 0; height: 86px; font-size: 14px; resize: none;"></textarea>
              </div>
              <div style="margin-bottom: 14px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select" style="height: 40px; font-size: 14px; padding: 8px 12px;" required>
                  <option value="aktif">Aktif</option>
                  <option value="nonaktif">Nonaktif</option>
                </select>
              </div>
              <div style="margin-bottom: 0;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Foto</label>
                <input type="file" name="foto" class="form-control" style="height: 40px; font-size: 14px; padding: 8px 12px;" accept="image/*">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #E5E7EB; display: flex; justify-content: flex-end; gap: 8px;">
          <button type="button" class="btn btn-secondary" data-pc-modal-dismiss="#createModal" style="padding: 8px 16px; font-size: 14px;">Batal</button>
          <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-size: 14px;">
            <i class="ti ti-device-floppy"></i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modals -->
@foreach($dokters as $dokter)
<div class="modal fade" id="editModal{{ $dokter->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 880px;">
    <div class="modal-content">
      <div class="modal-header" style="padding: 18px 24px; border-bottom: 1px solid #E5E7EB;">
        <h5 class="modal-title" style="font-size: 18px; font-weight: 600; margin: 0;">Edit Dokter</h5>
        <button type="button" class="btn-close" data-pc-modal-dismiss="#editModal{{ $dokter->id }}" aria-label="Close"></button>
      </div>
      <form action="{{ route('dokter.update', $dokter) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body" style="padding: 24px; max-height: 85vh; overflow-y: auto;">
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <div>
              <div style="margin-bottom: 14px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Nama <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control" style="border: none; border-bottom: 1px solid #E5E7EB; border-radius: 0; padding: 8px 0; height: 40px; font-size: 14px;" value="{{ $dokter->nama }}" required>
              </div>
              <div style="margin-bottom: 14px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Spesialisasi <span class="text-danger">*</span></label>
                <input type="text" name="spesialisasi" class="form-control" style="border: none; border-bottom: 1px solid #E5E7EB; border-radius: 0; padding: 8px 0; height: 40px; font-size: 14px;" value="{{ $dokter->spesialisasi }}" required>
              </div>
              <div style="margin-bottom: 14px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">No. SIP <span class="text-danger">*</span></label>
                <input type="text" name="no_sip" class="form-control" style="border: none; border-bottom: 1px solid #E5E7EB; border-radius: 0; padding: 8px 0; height: 40px; font-size: 14px;" value="{{ $dokter->no_sip }}" required>
              </div>
              <div style="margin-bottom: 0;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" style="border: none; border-bottom: 1px solid #E5E7EB; border-radius: 0; padding: 8px 0; height: 40px; font-size: 14px;" value="{{ $dokter->email }}" required>
              </div>
            </div>
            <div>
              <div style="margin-bottom: 14px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Telepon <span class="text-danger">*</span></label>
                <input type="text" name="telepon" class="form-control" style="border: none; border-bottom: 1px solid #E5E7EB; border-radius: 0; padding: 8px 0; height: 40px; font-size: 14px;" value="{{ $dokter->telepon }}" required>
              </div>
              <div style="margin-bottom: 14px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Alamat</label>
                <textarea name="alamat" class="form-control" style="border: none; border-bottom: 1px solid #E5E7EB; border-radius: 0; padding: 8px 0; height: 86px; font-size: 14px; resize: none;">{{ $dokter->alamat }}</textarea>
              </div>
              <div style="margin-bottom: 14px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select" style="height: 40px; font-size: 14px; padding: 8px 12px;" required>
                  <option value="aktif" {{ $dokter->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                  <option value="nonaktif" {{ $dokter->status === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
              </div>
              <div style="margin-bottom: 0;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500;">Foto</label>
                @if($dokter->foto)
                <div style="margin-bottom: 8px;">
                  <img src="{{ asset('storage/' . $dokter->foto) }}" width="80" class="rounded">
                </div>
                @endif
                <input type="file" name="foto" class="form-control" style="height: 40px; font-size: 14px; padding: 8px 12px;" accept="image/*">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #E5E7EB; display: flex; justify-content: flex-end; gap: 8px;">
          <button type="button" class="btn btn-secondary" data-pc-modal-dismiss="#editModal{{ $dokter->id }}" style="padding: 8px 16px; font-size: 14px;">Batal</button>
          <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-size: 14px;">
            <i class="ti ti-device-floppy"></i> Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal{{ $dokter->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
    <div class="modal-content">
      <div class="modal-header" style="padding: 18px 24px; border-bottom: 1px solid #E5E7EB;">
        <h5 class="modal-title" style="font-size: 18px; font-weight: 600; margin: 0;">Detail Dokter</h5>
        <button type="button" class="btn-close" data-pc-modal-dismiss="#viewModal{{ $dokter->id }}" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="padding: 32px 24px;">
        <div style="text-align: center; margin-top: 12px;">
          <div style="display: inline-flex; margin: 0 auto; justify-content: center;">
            @php
              $viewAvatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($dokter->nama) . '&background=4F46E5&color=fff&size=150';
              if ($dokter->foto) {
                if (filter_var($dokter->foto, FILTER_VALIDATE_URL)) {
                  $viewAvatarUrl = $dokter->foto;
                } else {
                  $viewAvatarUrl = asset('storage/' . $dokter->foto);
                }
              }
            @endphp
            <img class="rounded-circle" src="{{ $viewAvatarUrl }}" alt="Foto Dokter" style="width: 80px; height: 80px; object-fit: cover;" />
          </div>
          <h5 style="margin-bottom: 4px; margin-top: 16px; font-size: 18px; font-weight: 600;">{{ $dokter->nama }}</h5>
          <p style="color: #6B7280; font-size: 14px; margin-bottom: 0;">{{ $dokter->spesialisasi }}</p>
          <hr style="margin: 16px 0; border-color: rgba(107, 114, 128, 0.1);" />
          
          <div style="display: flex; align-items: center; gap: 12px; width: 100%; margin-bottom: 12px;">
            <i class="ti ti-mail" style="font-size: 18px; color: #6B7280;"></i>
            <p style="margin-bottom: 0; font-size: 14px; text-align: left;">{{ $dokter->email }}</p>
          </div>
          <div style="display: flex; align-items: center; gap: 12px; width: 100%; margin-bottom: 12px;">
            <i class="ti ti-phone" style="font-size: 18px; color: #6B7280;"></i>
            <p style="margin-bottom: 0; font-size: 14px; text-align: left;">{{ $dokter->telepon }}</p>
          </div>
          <div style="display: flex; align-items: center; gap: 12px; width: 100%; margin-bottom: 12px;">
            <i class="ti ti-id" style="font-size: 18px; color: #6B7280;"></i>
            <p style="margin-bottom: 0; font-size: 14px; text-align: left;">{{ $dokter->no_sip }}</p>
          </div>
          <div style="display: flex; align-items: center; gap: 12px; width: 100%; margin-bottom: 12px;">
            <i class="ti ti-map-pin" style="font-size: 18px; color: #6B7280;"></i>
            <p style="margin-bottom: 0; font-size: 14px; text-align: left;">{{ $dokter->alamat ?? '-' }}</p>
          </div>
          <div style="display: flex; align-items: center; gap: 12px; width: 100%;">
            <i class="ti ti-circle-check" style="font-size: 18px; color: #6B7280;"></i>
            <p style="margin-bottom: 0; font-size: 14px; text-align: left;">
              @if($dokter->status === 'aktif')
                <span class="badge bg-success" style="font-size: 12px; padding: 4px 8px;">Aktif</span>
              @else
                <span class="badge bg-secondary" style="font-size: 12px; padding: 4px 8px;">Nonaktif</span>
              @endif
            </p>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #E5E7EB; display: flex; justify-content: flex-end;">
        <button type="button" class="btn btn-secondary" data-pc-modal-dismiss="#viewModal{{ $dokter->id }}" style="padding: 8px 16px; font-size: 14px;">Tutup</button>
      </div>
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
    
    fetch('{{ route("dokter.index") }}?' + formData.toString(), {
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
