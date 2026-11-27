@extends('layouts.app')

@section('title', 'Work Schedules')

@section('content')
<div class="page-header">
  <div class="page-block">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item" aria-current="page">Work Schedules</li>
    </ul>
    <div class="page-header-title">
      <h2 class="mb-0">Work Schedules</h2>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header" style="padding: 20px 24px;">
        <div class="d-flex align-items-center justify-content-between">
          <h5 class="mb-0" style="font-size: 16px; font-weight: 600;">Manage Work Schedules</h5>
          <button type="button" class="btn btn-primary" data-pc-toggle="modal" data-pc-target="#createModal" style="padding: 8px 16px; font-size: 14px; border-radius: 6px;">
            <i class="ti ti-plus" style="font-size: 16px;"></i> Add Schedule
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
                <th style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB;">Name</th>
                <th style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB; width: 180px;">Code</th>
                <th style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB; width: 140px;">Time</th>
                <th style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB; width: 120px;">Color</th>
                <th style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB; width: 130px;">Assignments</th>
                <th style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB; width: 100px;">Status</th>
                <th style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB; width: 140px; text-align: center;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($schedules as $schedule)
              <tr style="border-bottom: 1px solid #F3F4F6;">
                <td style="padding: 12px 16px; vertical-align: middle;">
                  <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 4px; height: 36px; background: {{ $schedule->color }}; border-radius: 2px; flex-shrink: 0;"></div>
                    <div>
                      <div style="font-size: 14px; font-weight: 600; color: #111827;">{{ $schedule->name }}</div>
                      <div style="font-size: 12px; color: #6B7280;">{{ $schedule->description }}</div>
                    </div>
                  </div>
                </td>
                <td style="padding: 16px; vertical-align: middle;">
                  <code style="font-size: 13px; padding: 4px 8px; background: #F3F4F6; border-radius: 4px; color: #374151;">{{ $schedule->code }}</code>
                </td>
                <td style="padding: 16px; vertical-align: middle;">
                  <div style="font-size: 14px; color: #374151; white-space: nowrap;">
                    {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}
                  </div>
                </td>
                <td style="padding: 16px; vertical-align: middle;">
                  <span class="badge" style="background: {{ $schedule->color }}; color: white; font-size: 12px; padding: 6px 10px; font-weight: 500;">{{ $schedule->color }}</span>
                </td>
                <td style="padding: 16px; vertical-align: middle;">
                  <span class="badge bg-info" style="font-size: 12px; padding: 6px 10px; font-weight: 500;">{{ $schedule->assignments->count() }} assigned</span>
                </td>
                <td style="padding: 16px; vertical-align: middle;">
                  @if($schedule->status === 'active')
                    <span class="badge bg-success" style="font-size: 12px; padding: 6px 10px; font-weight: 500;">Active</span>
                  @else
                    <span class="badge bg-secondary" style="font-size: 12px; padding: 6px 10px; font-weight: 500;">Inactive</span>
                  @endif
                </td>
                <td style="padding: 16px; vertical-align: middle; text-align: center;">
                  <div class="d-inline-flex" style="gap: 6px;">
                    <a href="{{ route('work-schedules.assign', $schedule) }}" class="btn btn-sm btn-info" title="Assign Staff" style="padding: 6px 10px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px;">
                      <i class="ti ti-users" style="font-size: 16px;"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-warning" title="Edit" data-pc-toggle="modal" data-pc-target="#editModal{{ $schedule->id }}" style="padding: 6px 10px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px;">
                      <i class="ti ti-edit" style="font-size: 16px;"></i>
                    </button>
                    <form action="{{ route('work-schedules.destroy', $schedule) }}" method="POST" style="display: inline-block; margin: 0;" onsubmit="return confirm('Are you sure?')">
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
                <td colspan="7" class="text-center" style="padding: 48px 16px;">
                  <i class="ti ti-calendar-off" style="font-size: 56px; color: #D1D5DB; display: block; margin-bottom: 12px;"></i>
                  <p style="color: #6B7280; font-size: 14px; margin: 0;">No work schedules found</p>
                </td>
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
