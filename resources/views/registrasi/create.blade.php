@extends('layouts.app')

@section('title', 'Registrasi Baru')

@section('content')
<div class="page-header">
  <div class="page-block">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('registrasi.index') }}">Registrasi</a></li>
      <li class="breadcrumb-item" aria-current="page">Registrasi Baru</li>
    </ul>
    <div class="page-header-title">
      <h2 class="mb-0">Registrasi Baru</h2>
    </div>
  </div>
</div>

<div class="grid grid-cols-12 gap-x-6">
  <div class="col-span-12">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('registrasi.store') }}" method="POST">
          @csrf
          <div class="container">
            <div class="grid grid-cols-12 gap-x-6">
              <div class="col-span-12 sm:col-span-6">
                <div class="mb-3">
                  <label class="form-label">Tanggal Kunjungan *</label>
                  <input type="date" id="tanggalKunjungan" name="tanggal_kunjungan" class="form-control" required value="{{ date('Y-m-d') }}" />
                </div>
              </div>
              <div class="col-span-12 sm:col-span-6">
                <div class="mb-3">
                  <label class="form-label">Pasien *</label>
                  <select name="pasien_id" class="form-select" required>
                    <option value="">Pilih Pasien</option>
                    @foreach($pasiens as $pasien)
                      <option value="{{ $pasien->id }}">{{ $pasien->nama }} - {{ $pasien->no_rm }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            
            <div id="shiftDokterContainer"></div>
            
            <input type="hidden" name="dokter_id" id="selectedDokterId" required>
            <input type="hidden" name="work_schedule_id" id="selectedWorkScheduleId" required>
            <input type="hidden" name="schedule_assignment_id" id="selectedScheduleAssignmentId" required>
            
            <div id="timeBookingContainer" style="display: none;">
              <div class="mb-4 p-4 border rounded-lg bg-blue-50">
                <h5 class="font-semibold mb-3">Waktu Booking</h5>
                <div class="grid grid-cols-12 gap-x-6">
                  <div class="col-span-12 sm:col-span-6">
                    <div class="mb-3">
                      <label class="form-label">Jam Mulai *</label>
                      <input type="time" name="jam_mulai" id="jamMulai" class="form-control" required step="60">
                      <small class="text-muted" id="jamMulaiHint"></small>
                    </div>
                  </div>
                  <div class="col-span-12 sm:col-span-6">
                    <div class="mb-3">
                      <label class="form-label">Jam Selesai *</label>
                      <input type="time" name="jam_selesai" id="jamSelesai" class="form-control" required step="60">
                      <small class="text-muted" id="jamSelesaiHint"></small>
                    </div>
                  </div>
                </div>
                <div id="bookingWarning" class="alert alert-warning" style="display: none; margin-top: 10px;"></div>
              </div>
            </div>
            
            <div class="grid grid-cols-12 gap-x-6">
              <div class="col-span-12 sm:col-span-6">
                <div class="mb-3">
                  <label class="form-label">Jenis Kunjungan *</label>
                  <select name="jenis_kunjungan" class="form-select" required>
                    <option value="baru">Baru</option>
                    <option value="kontrol">Kontrol</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Keluhan</label>
              <textarea name="keluhan" class="form-control" rows="4" placeholder="Masukkan keluhan pasien..."></textarea>
            </div>
            <div class="text-right mt-4">
              <a href="{{ route('registrasi.index') }}" class="btn btn-outline-secondary mr-2">Batal</a>
              <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
let availableDoctors = [];

document.getElementById('tanggalKunjungan').addEventListener('change', function() {
    const tanggal = this.value;
    const container = document.getElementById('shiftDokterContainer');
    const submitBtn = document.getElementById('submitBtn');
    
    if (!tanggal) {
        container.innerHTML = '';
        submitBtn.disabled = true;
        return;
    }
    
    container.innerHTML = '<div class="text-center py-4"><i class="ti ti-loader animate-spin text-2xl"></i> Memuat dokter tersedia...</div>';
    submitBtn.disabled = true;
    
    fetch(`/api/registrasi/available-doctors?tanggal=${tanggal}`)
        .then(response => response.json())
        .then(data => {
            availableDoctors = data;
            
            if (data.length === 0) {
                container.innerHTML = `
                    <div class="alert alert-warning mb-4">
                        <i class="ti ti-alert-circle"></i> Tidak ada dokter yang memiliki jadwal praktik pada tanggal ini.
                    </div>
                `;
                submitBtn.disabled = true;
                return;
            }
            
            let html = '<div class="mb-4">';
            html += '<label class="form-label">Pilih Dokter & Shift *</label>';
            html += '<div class="mb-3"><input type="text" id="searchDokter" class="form-control" placeholder="Cari nama dokter..."></div>';
            html += '<div style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 16px;">';
            html += '<style>@media (min-width: 768px) { .shift-grid { grid-template-columns: repeat(2, 1fr) !important; } } @media (min-width: 1024px) { .shift-grid { grid-template-columns: repeat(3, minmax(0, 1fr)) !important; } }</style>';
            html += '<div class="shift-grid" style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 16px;">';
            
            data.forEach((shiftData, index) => {
                const shiftId = `shift-${index}`;
                html += `
                    <div class="shift-card" style="border: 1px solid #E5E7EB; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column;">
                        <button type="button" onclick="toggleShift('${shiftId}')" style="padding: 12px 16px; font-weight: 600; color: white; display: flex; align-items: center; justify-content: space-between; background-color: ${shiftData.shift.color}; border: none; cursor: pointer; width: 100%;">
                            <span style="font-size: 14px;">${shiftData.shift.name} (${shiftData.shift.start_time} - ${shiftData.shift.end_time})</span>
                            <i id="icon-${shiftId}" class="ti ti-chevron-down"></i>
                        </button>
                        <div id="${shiftId}" style="padding: 12px; background-color: #F9FAFB; flex: 1;">
                            <div style="display: flex; flex-direction: column; gap: 8px;">
                `;
                
                shiftData.dokters.forEach(dokter => {
                    html += `
                        <label class="dokter-item" data-dokter-name="${dokter.nama.toLowerCase()}" style="display: flex; align-items: flex-start; padding: 8px; background-color: white; border: 1px solid #E5E7EB; border-radius: 8px; cursor: pointer; transition: border-color 0.2s;">
                            <input type="radio" name="dokter_shift" value="${dokter.id}" 
                                   data-dokter-id="${dokter.id}"
                                   data-shift-id="${shiftData.shift.id}"
                                   data-assignment-id="${dokter.assignment_id}"
                                   style="margin-top: 4px; margin-right: 8px; flex-shrink: 0;">
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 600; font-size: 14px; color: #111827; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${dokter.nama}</div>
                                <div style="font-size: 12px; color: #6B7280; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${dokter.spesialisasi}</div>
                                <div style="font-size: 12px; color: #9CA3AF; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${dokter.room || 'Ruang belum ditentukan'}</div>
                            </div>
                        </label>
                    `;
                });
                
                html += `
                            </div>
                        </div>
                    </div>
                `;
            });
            
            html += '</div></div></div>';
            container.innerHTML = html;
            
            // Search functionality
            document.getElementById('searchDokter').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                document.querySelectorAll('.dokter-item').forEach(item => {
                    const dokterName = item.dataset.dokterName;
                    item.style.display = dokterName.includes(searchTerm) ? '' : 'none';
                });
            });
            
            // Add event listeners to radio buttons
            document.querySelectorAll('input[name="dokter_shift"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    document.getElementById('selectedDokterId').value = this.dataset.dokterId;
                    document.getElementById('selectedWorkScheduleId').value = this.dataset.shiftId;
                    document.getElementById('selectedScheduleAssignmentId').value = this.dataset.assignmentId;
                    
                    // Show time booking section and load booked slots
                    loadBookedSlots();
                });
            });
        })
        .catch(error => {
            console.error('Error:', error);
            container.innerHTML = `
                <div class="alert alert-danger mb-4">
                    <i class="ti ti-alert-circle"></i> Gagal memuat data dokter. Silakan coba lagi.
                </div>
            `;
            submitBtn.disabled = true;
        });
});

// Trigger on page load if date is set
if (document.getElementById('tanggalKunjungan').value) {
    document.getElementById('tanggalKunjungan').dispatchEvent(new Event('change'));
}

let bookedSlots = [];
let shiftStart = '';
let shiftEnd = '';

function loadBookedSlots() {
    const tanggal = document.getElementById('tanggalKunjungan').value;
    const dokterId = document.getElementById('selectedDokterId').value;
    const workScheduleId = document.getElementById('selectedWorkScheduleId').value;
    
    if (!tanggal || !dokterId || !workScheduleId) return;
    
    fetch(`/api/registrasi/booked-slots?tanggal=${tanggal}&dokter_id=${dokterId}&work_schedule_id=${workScheduleId}`)
        .then(response => response.json())
        .then(data => {
            bookedSlots = data.booked_slots;
            shiftStart = data.shift_start;
            shiftEnd = data.shift_end;
            
            // Show time booking container
            document.getElementById('timeBookingContainer').style.display = 'block';
            
            // Set min/max for time inputs
            document.getElementById('jamMulai').min = shiftStart;
            document.getElementById('jamMulai').max = shiftEnd;
            document.getElementById('jamSelesai').min = shiftStart;
            document.getElementById('jamSelesai').max = shiftEnd;
            
            // Update hints
            updateTimeHints();
            
            // Reset submit button
            document.getElementById('submitBtn').disabled = true;
        })
        .catch(error => {
            console.error('Error loading booked slots:', error);
        });
}

function updateTimeHints() {
    const jamMulaiHint = document.getElementById('jamMulaiHint');
    const jamSelesaiHint = document.getElementById('jamSelesaiHint');
    
    if (bookedSlots.length === 0) {
        jamMulaiHint.textContent = `Tersedia: ${shiftStart} - ${shiftEnd}`;
    } else {
        jamMulaiHint.textContent = `Shift: ${shiftStart} - ${shiftEnd} | ${bookedSlots.length} booking aktif`;
    }
    
    jamSelesaiHint.textContent = 'Pilih jam mulai terlebih dahulu';
}

function timeToMinutes(time) {
    const [hours, minutes] = time.split(':').map(Number);
    return hours * 60 + minutes;
}

function minutesToTime(minutes) {
    const hours = Math.floor(minutes / 60);
    const mins = minutes % 60;
    return `${String(hours).padStart(2, '0')}:${String(mins).padStart(2, '0')}`;
}

function checkTimeConflict(start, end) {
    const startMinutes = timeToMinutes(start);
    const endMinutes = timeToMinutes(end);
    
    for (let booking of bookedSlots) {
        const bookingStart = timeToMinutes(booking.start);
        const bookingEnd = timeToMinutes(booking.end);
        
        // Check overlap
        if ((startMinutes >= bookingStart && startMinutes < bookingEnd) ||
            (endMinutes > bookingStart && endMinutes <= bookingEnd) ||
            (startMinutes <= bookingStart && endMinutes >= bookingEnd)) {
            return booking;
        }
    }
    return null;
}

function findNextAvailableTime(afterTime) {
    const afterMinutes = timeToMinutes(afterTime);
    const shiftEndMinutes = timeToMinutes(shiftEnd);
    
    // Sort booked slots by start time
    const sortedSlots = [...bookedSlots].sort((a, b) => timeToMinutes(a.start) - timeToMinutes(b.start));
    
    for (let booking of sortedSlots) {
        const bookingStart = timeToMinutes(booking.start);
        const bookingEnd = timeToMinutes(booking.end);
        
        if (afterMinutes < bookingEnd) {
            // If requested time is before or during this booking, suggest after it
            if (afterMinutes < bookingStart) {
                return minutesToTime(afterMinutes); // Time is available before this booking
            } else {
                return minutesToTime(bookingEnd); // Suggest time after this booking
            }
        }
    }
    
    // No conflicts, return the requested time if within shift
    return afterMinutes <= shiftEndMinutes ? minutesToTime(afterMinutes) : null;
}

document.getElementById('jamMulai').addEventListener('change', function() {
    const jamMulai = this.value;
    const jamSelesai = document.getElementById('jamSelesai').value;
    const warningDiv = document.getElementById('bookingWarning');
    const jamSelesaiHint = document.getElementById('jamSelesaiHint');
    
    if (!jamMulai) {
        warningDiv.style.display = 'none';
        jamSelesaiHint.textContent = 'Pilih jam mulai terlebih dahulu';
        return;
    }
    
    // Check if start time conflicts with existing bookings
    const startMinutes = timeToMinutes(jamMulai);
    let conflictFound = false;
    
    for (let booking of bookedSlots) {
        const bookingStart = timeToMinutes(booking.start);
        const bookingEnd = timeToMinutes(booking.end);
        
        if (startMinutes >= bookingStart && startMinutes < bookingEnd) {
            conflictFound = true;
            const nextAvailable = minutesToTime(bookingEnd);
            warningDiv.innerHTML = `<i class="ti ti-alert-circle"></i> Waktu ${jamMulai} sudah dibooking (${booking.start} - ${booking.end}). Waktu tersedia berikutnya: ${nextAvailable}`;
            warningDiv.style.display = 'block';
            this.value = '';
            document.getElementById('submitBtn').disabled = true;
            return;
        }
    }
    
    warningDiv.style.display = 'none';
    
    // Find next booking after start time to set max end time
    let maxEndTime = shiftEnd;
    for (let booking of bookedSlots) {
        const bookingStart = timeToMinutes(booking.start);
        if (bookingStart > startMinutes) {
            maxEndTime = booking.start;
            break;
        }
    }
    
    jamSelesaiHint.textContent = `Maksimal: ${maxEndTime}`;
    document.getElementById('jamSelesai').max = maxEndTime;
    
    // Validate existing end time
    if (jamSelesai) {
        validateEndTime();
    }
});

document.getElementById('jamSelesai').addEventListener('change', function() {
    validateEndTime();
});

function validateEndTime() {
    const jamMulai = document.getElementById('jamMulai').value;
    const jamSelesai = document.getElementById('jamSelesai').value;
    const warningDiv = document.getElementById('bookingWarning');
    const submitBtn = document.getElementById('submitBtn');
    
    if (!jamMulai || !jamSelesai) {
        submitBtn.disabled = true;
        return;
    }
    
    const startMinutes = timeToMinutes(jamMulai);
    const endMinutes = timeToMinutes(jamSelesai);
    
    // Check if end time is after start time
    if (endMinutes <= startMinutes) {
        warningDiv.innerHTML = '<i class="ti ti-alert-circle"></i> Jam selesai harus lebih besar dari jam mulai';
        warningDiv.style.display = 'block';
        submitBtn.disabled = true;
        return;
    }
    
    // Check conflict
    const conflict = checkTimeConflict(jamMulai, jamSelesai);
    if (conflict) {
        warningDiv.innerHTML = `<i class="ti ti-alert-circle"></i> Waktu booking bertabrakan dengan booking lain (${conflict.start} - ${conflict.end})`;
        warningDiv.style.display = 'block';
        submitBtn.disabled = true;
        return;
    }
    
    // All validations passed
    warningDiv.style.display = 'none';
    submitBtn.disabled = false;
}

function toggleShift(shiftId) {
    const content = document.getElementById(shiftId);
    const icon = document.getElementById('icon-' + shiftId);
    
    if (content.style.display === 'none') {
        content.style.display = 'block';
        icon.classList.remove('ti-chevron-right');
        icon.classList.add('ti-chevron-down');
    } else {
        content.style.display = 'none';
        icon.classList.remove('ti-chevron-down');
        icon.classList.add('ti-chevron-right');
    }
}
</script>
@endsection
