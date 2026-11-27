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

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header" style="padding: 20px 24px;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
          <h5 class="mb-0" style="font-size: 16px; font-weight: 600;">Daftar Dokter</h5>
          <button type="button" class="btn btn-primary" data-pc-toggle="modal" data-pc-target="#createModal" style="padding: 8px 16px; font-size: 14px; border-radius: 6px;">
            <i class="ti ti-plus" style="font-size: 16px;"></i> Tambah Dokter
          </button>
        </div>
      </div>
      <div class="card-body" style="padding: 24px;">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="table-responsive">
          <table class="table table-hover" style="margin-bottom: 0;">
            <thead>
              <tr>
                <th style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB;">Nama</th>
                <th style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB; width: 200px;">Spesialisasi</th>
                <th style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB; width: 150px;">No. SIP</th>
                <th style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB; width: 140px;">Telepon</th>
                <th style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB; width: 100px;">Status</th>
                <th style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB; width: 140px; text-align: center;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($dokters as $dokter)
              <tr style="border-bottom: 1px solid #F3F4F6;">
                <td style="padding: 16px; vertical-align: middle;">
                  <div style="display: flex; align-items: center; gap: 12px;">
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
                    <img src="{{ $avatarUrl }}" class="rounded-circle" width="40" height="40" style="object-fit: cover; flex-shrink: 0; min-width: 40px; min-height: 40px; max-width: 40px; max-height: 40px;" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($dokter->nama) }}&background=4F46E5&color=fff&size=80'">
                    <div style="min-width: 0;">
                      <div style="font-size: 14px; font-weight: 600; color: #111827;">{{ $dokter->nama }}</div>
                      <div style="font-size: 13px; color: #6B7280;">{{ $dokter->email }}</div>
                    </div>
                  </div>
                </td>
                <td style="padding: 16px; vertical-align: middle;">
                  <div style="font-size: 14px; color: #374151;">{{ $dokter->spesialisasi }}</div>
                </td>
                <td style="padding: 16px; vertical-align: middle;">
                  <code style="font-size: 13px; padding: 4px 8px; background: #F3F4F6; border-radius: 4px; color: #374151;">{{ $dokter->no_sip }}</code>
                </td>
                <td style="padding: 16px; vertical-align: middle;">
                  <div style="font-size: 14px; color: #374151;">{{ $dokter->telepon }}</div>
                </td>
                <td style="padding: 16px; vertical-align: middle;">
                  @if($dokter->status === 'aktif')
                    <span class="badge bg-success" style="font-size: 12px; padding: 6px 10px; font-weight: 500;">Aktif</span>
                  @else
                    <span class="badge bg-secondary" style="font-size: 12px; padding: 6px 10px; font-weight: 500;">Nonaktif</span>
                  @endif
                </td>
                <td style="padding: 16px; vertical-align: middle; text-align: center;">
                  <div class="d-inline-flex" style="gap: 6px;">
                    <button type="button" class="btn btn-sm btn-info" title="View" data-pc-toggle="modal" data-pc-target="#viewModal{{ $dokter->id }}" style="padding: 6px 10px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px;">
                      <i class="ti ti-eye" style="font-size: 16px;"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-warning" title="Edit" data-pc-toggle="modal" data-pc-target="#editModal{{ $dokter->id }}" style="padding: 6px 10px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px;">
                      <i class="ti ti-edit" style="font-size: 16px;"></i>
                    </button>
                    <form action="{{ route('dokter.destroy', $dokter) }}" method="POST" style="display: inline-block; margin: 0;" onsubmit="return confirm('Yakin ingin menghapus?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger" title="Delete" style="padding: 6px 10px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px;">
                        <i class="ti ti-trash" style="font-size: 16px;"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center" style="padding: 48px 16px;">
                  <i class="ti ti-user-off" style="font-size: 56px; color: #D1D5DB; display: block; margin-bottom: 12px;"></i>
                  <p style="color: #6B7280; font-size: 14px; margin: 0;">Belum ada data dokter</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        @if($dokters->hasPages())
        <div class="d-flex justify-content-end mt-3">
          {{ $dokters->links() }}
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
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
@endsection
