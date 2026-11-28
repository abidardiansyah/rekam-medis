@extends('layouts.app')

@section('title', 'Jadwal Kerja')

@section('content')
<div class="page-header">
  <div class="page-block">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item" aria-current="page">Jadwal Kerja</li>
    </ul>
    <div class="page-header-title">
      <h2 class="mb-0">Jadwal Kerja</h2>
    </div>
  </div>
</div>

<div class="grid grid-cols-12 gap-x-6">
  <div class="col-span-12">
    <div class="card table-card">
      <div class="card-header flex items-center justify-between">
        <h5>Kelola Jadwal Kerja</h5>
        <button type="button" class="btn btn-primary" data-pc-toggle="modal" data-pc-target="#createModal">
          <i class="ti ti-plus"></i> Tambah Jadwal
        </button>
      </div>
      <div class="card-body !pt-3">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="table-responsive">
          <table class="table table-hover" id="pc-dt-simple">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Kode</th>
                <th>Waktu</th>
                <th>Warna</th>
                <th>Penugasan</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($schedules as $schedule)
              <tr>
                <td>
                  <div class="flex items-center">
                    <div style="width: 4px; height: 36px; background: {{ $schedule->color }}; border-radius: 2px; margin-right: 12px;"></div>
                    <div>
                      <h6 class="mb-0">{{ $schedule->name }}</h6>
                      <small class="text-muted">{{ $schedule->description }}</small>
                    </div>
                  </div>
                </td>
                <td><code>{{ $schedule->code }}</code></td>
                <td>{{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}</td>
                <td><span class="badge" style="background: {{ $schedule->color }}; color: white;">{{ $schedule->color }}</span></td>
                <td><span class="badge bg-info">{{ $schedule->assignments->count() }} assigned</span></td>
                <td>
                  @if($schedule->status === 'active')
                    <span class="text-success-500"><i class="fas fa-circle text-[10px] mr-2.5"></i> Aktif</span>
                  @else
                    <span class="text-secondary-500"><i class="fas fa-circle text-[10px] mr-2.5"></i> Nonaktif</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('work-schedules.assign', $schedule) }}" class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary" title="Assign Staff">
                    <i class="ti ti-users text-xl leading-none"></i>
                  </a>
                  <button type="button" class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary" data-pc-toggle="modal" data-pc-target="#editModal{{ $schedule->id }}" title="Edit">
                    <i class="ti ti-edit text-xl leading-none"></i>
                  </button>
                  <form action="{{ route('work-schedules.destroy', $schedule) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-8 h-8 rounded-xl inline-flex items-center justify-center btn-link-secondary" title="Delete">
                      <i class="ti ti-trash text-xl leading-none"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center">Belum ada data jadwal kerja</td>
              </tr>
              @endforelse
            </tbody>
          </table>
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
        <h5 class="modal-title">Create Work Schedule</h5>
        <button type="button" class="btn-close" data-pc-modal-dismiss="#createModal" aria-label="Close"></button>
      </div>
      <form action="{{ route('work-schedules.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Schedule Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Code <span class="text-danger">*</span></label>
            <input type="text" name="code" class="form-control" placeholder="e.g., SHIFT-MORNING" required>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Start Time <span class="text-danger">*</span></label>
              <input type="time" name="start_time" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">End Time <span class="text-danger">*</span></label>
              <input type="time" name="end_time" class="form-control" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Color <span class="text-danger">*</span></label>
            <input type="color" name="color" class="form-control form-control-color" value="#3B82F6" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-select" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-pc-modal-dismiss="#createModal">Cancel</button>
          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy"></i> Save Schedule
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modals -->
@foreach($schedules as $schedule)
<div class="modal fade" id="editModal{{ $schedule->id }}" tabindex="-1" aria-hidden="true" data-pc-modal-show="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Work Schedule</h5>
        <button type="button" class="btn-close" data-pc-modal-dismiss="#editModal{{ $schedule->id }}" aria-label="Close"></button>
      </div>
      <form action="{{ route('work-schedules.update', $schedule) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Schedule Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ $schedule->name }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Code <span class="text-danger">*</span></label>
            <input type="text" name="code" class="form-control" value="{{ $schedule->code }}" required>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Start Time <span class="text-danger">*</span></label>
              <input type="time" name="start_time" class="form-control" value="{{ substr($schedule->start_time, 0, 5) }}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">End Time <span class="text-danger">*</span></label>
              <input type="time" name="end_time" class="form-control" value="{{ substr($schedule->end_time, 0, 5) }}" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Color <span class="text-danger">*</span></label>
            <input type="color" name="color" class="form-control form-control-color" value="{{ $schedule->color }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $schedule->description }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-select" required>
              <option value="active" {{ $schedule->status === 'active' ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ $schedule->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-pc-modal-dismiss="#editModal{{ $schedule->id }}">Cancel</button>
          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy"></i> Update Schedule
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
@endsection
