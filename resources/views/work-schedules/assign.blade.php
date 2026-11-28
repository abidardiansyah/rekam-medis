@extends('layouts.app')

@section('title', 'Assign Staff to Schedule')

@section('content')
<div class="page-header">
  <div class="page-block">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('work-schedules.index') }}">Jadwal Kerja</a></li>
      <li class="breadcrumb-item" aria-current="page">Assign Staff</li>
    </ul>
    <div class="page-header-title">
      <h2 class="mb-0">Assign Staff to {{ $workSchedule->name }}</h2>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12" style="padding-left: 0; padding-right: 0;">
    <div style="display: flex; gap: 20px; width: 100%;">
      <!-- Assignment Form -->
      <div style="flex: 0 0 45%; max-width: 45%; min-width: 0; box-sizing: border-box;">
        <div class="card" style="height: 100%;">
          <div class="card-header" style="padding: 16px 20px; border-bottom: 1px solid #E5E7EB;">
            <h5 style="margin: 0; font-size: 15px; font-weight: 600;">Add New Assignment</h5>
          </div>
          <div class="card-body" style="padding: 20px;">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 16px; padding: 12px 16px; font-size: 14px;">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('work-schedules.store-assignment', $workSchedule) }}" method="POST">
              @csrf
              
              <div style="margin-bottom: 14px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 500;">Staff Type <span class="text-danger">*</span></label>
                <select name="staff_type" id="staffType" class="form-select @error('staff_type') is-invalid @enderror" style="height: 40px; font-size: 14px; width: 100%; padding: 8px 12px; line-height: 1.5;" required>
                  <option value="">Select Type</option>
                  <option value="dokter">Dokter</option>
                  <option value="perawat">Perawat</option>
                </select>
                @error('staff_type')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div style="margin-bottom: 14px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 500;">Staff <span class="text-danger">*</span></label>
                <select name="staff_id" id="staffSelect" class="form-select @error('staff_id') is-invalid @enderror" style="height: 40px; font-size: 14px; width: 100%; padding: 8px 12px; line-height: 1.5;" required>
                  <option value="">Select Staff</option>
                </select>
                @error('staff_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div style="margin-bottom: 14px;">
                <label class="form-label" style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 500;">Days <span class="text-danger">*</span></label>
                <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                  <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                    <input type="checkbox" name="days[]" value="Senin" class="form-check-input" style="margin: 0;">
                    <span style="font-size: 13px;">Senin</span>
                  </label>
                  <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                    <input type="checkbox" name="days[]" value="Selasa" class="form-check-input" style="margin: 0;">
                    <span style="font-size: 13px;">Selasa</span>
                  </label>
                  <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                    <input type="checkbox" name="days[]" value="Rabu" class="form-check-input" style="margin: 0;">
                    <span style="font-size: 13px;">Rabu</span>
                  </label>
                  <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                    <input type="checkbox" name="days[]" value="Kamis" class="form-check-input" style="margin: 0;">
                    <span style="font-size: 13px;">Kamis</span>
                  </label>
                  <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                    <input type="checkbox" name="days[]" value="Jumat" class="form-check-input" style="margin: 0;">
                    <span style="font-size: 13px;">Jumat</span>
                  </label>
                  <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                    <input type="checkbox" name="days[]" value="Sabtu" class="form-check-input" style="margin: 0;">
                    <span style="font-size: 13px;">Sabtu</span>
                  </label>
                  <label style="display: flex; align-items: center; gap: 6px; cursor: pointer;">
                    <input type="checkbox" name="days[]" value="Minggu" class="form-check-input" style="margin: 0;">
                    <span style="font-size: 13px;">Minggu</span>
                  </label>
                </div>
                @error('days')
                  <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
              </div>

              <div style="margin-bottom: 14px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 500;">Room</label>
                <input type="text" name="room" class="form-control @error('room') is-invalid @enderror" placeholder="e.g., Room 101" style="height: 40px; font-size: 14px; width: 100%; padding: 8px 12px; line-height: 1.5;">
                @error('room')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div style="margin-bottom: 16px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-size: 13px; font-weight: 500;">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" style="height: 40px; font-size: 14px; width: 100%; padding: 8px 12px; line-height: 1.5;" required>
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
                @error('status')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px 16px; font-size: 14px; border-radius: 6px;">
                <i class="ti ti-plus"></i> Add Assignment
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Current Assignments -->
      <div style="flex: 0 0 55%; max-width: 55%; min-width: 0; box-sizing: border-box;">
        <div class="card" style="height: 100%;">
          <div class="card-header" style="padding: 16px 20px; border-bottom: 1px solid #E5E7EB;">
            <h5 style="margin: 0; font-size: 15px; font-weight: 600;">Current Assignments</h5>
          </div>
          <div class="card-body" style="padding: 20px; overflow-x: auto;">
            <div class="table-responsive">
              <table class="table table-hover" style="margin-bottom: 0; width: 100%;">
                <thead>
                  <tr>
                    <th style="padding: 10px 12px; font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB;">Staff</th>
                    <th style="padding: 10px 12px; font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB;">Day</th>
                    <th style="padding: 10px 12px; font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB;">Room</th>
                    <th style="padding: 10px 12px; font-size: 12px; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #E5E7EB; text-align: center; width: 80px;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($assignments as $assignment)
                  <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 12px; vertical-align: middle;">
                      <div style="display: flex; align-items: center; gap: 8px;">
                        <img src="{{ $assignment->assignable->foto ?? 'https://ui-avatars.com/api/?name=' . urlencode($assignment->assignable->nama) . '&background=4F46E5&color=fff&size=80' }}" class="rounded-circle" width="32" height="32" style="object-fit: cover; min-width: 32px; min-height: 32px; flex-shrink: 0;">
                        <div style="min-width: 0;">
                          <div style="font-size: 13px; font-weight: 600; color: #111827;">{{ $assignment->assignable->nama }}</div>
                          @if($assignment->assignable_type === 'App\Models\Dokter')
                            <small style="font-size: 11px; color: #6B7280;">{{ $assignment->assignable->spesialisasi }}</small>
                          @else
                            <small style="font-size: 11px; color: #6B7280;">Perawat</small>
                          @endif
                        </div>
                      </div>
                    </td>
                    <td style="padding: 12px; vertical-align: middle;">
                      <div style="font-size: 13px; color: #374151; font-weight: 500;">{{ $assignment->day_of_week }}</div>
                    </td>
                    <td style="padding: 12px; vertical-align: middle;">
                      <div style="font-size: 13px; color: #374151;">{{ $assignment->room ?? '-' }}</div>
                    </td>
                    <td style="padding: 12px; vertical-align: middle; text-align: center;">
                      <form action="{{ route('work-schedules.destroy-assignment', $assignment) }}" method="POST" style="display: inline-block; margin: 0;" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Delete" style="padding: 6px 10px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px;">
                          <i class="ti ti-trash" style="font-size: 14px;"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4" class="text-center" style="padding: 48px 16px;">
                      <i class="ti ti-users-off" style="font-size: 48px; color: #D1D5DB; display: block; margin-bottom: 12px;"></i>
                      <p style="color: #6B7280; font-size: 13px; margin: 0;">No staff assigned yet</p>
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
  </div>
</div>

<style>
@media (max-width: 991px) {
  .col-12 > div[style*="grid-template-columns"] {
    display: block !important;
  }
  .col-12 > div[style*="grid-template-columns"] > div {
    margin-bottom: 20px;
  }
  .col-12 > div[style*="grid-template-columns"] > div:last-child {
    margin-bottom: 0;
  }
}
</style>

<script>
const dokters = @json($dokters);
const perawats = @json($perawats);

document.getElementById('staffType').addEventListener('change', function() {
  const staffSelect = document.getElementById('staffSelect');
  staffSelect.innerHTML = '<option value="">Select Staff</option>';
  
  const data = this.value === 'dokter' ? dokters : perawats;
  
  data.forEach(staff => {
    const option = document.createElement('option');
    option.value = staff.id;
    option.textContent = staff.nama + (staff.spesialisasi ? ` - ${staff.spesialisasi}` : '');
    staffSelect.appendChild(option);
  });
});
</script>
@endsection
