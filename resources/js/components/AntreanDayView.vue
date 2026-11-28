<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
      <div class="flex items-center gap-2">
        <button @click="goToPreviousDay" class="btn btn-sm btn-outline-secondary">
          <i class="ti ti-chevron-left"></i>
        </button>
        <button @click="goToToday" class="btn btn-sm btn-primary">Hari Ini</button>
        <button @click="goToNextDay" class="btn btn-sm btn-outline-secondary">
          <i class="ti ti-chevron-right"></i>
        </button>
      </div>
      <h2 class="text-lg font-semibold">{{ formattedDate }}</h2>
    </div>

    <!-- Shift Sections -->
    <div v-for="shift in shiftsWithDoctors" :key="shift.id" class="border rounded-lg bg-white shadow-sm overflow-hidden mb-4">
      <!-- Shift Header -->
      <div @click="toggleShift(shift.id)" class="px-6 py-3 border-b flex items-center justify-between bg-gradient-to-r from-gray-50 to-gray-100 cursor-pointer hover:from-gray-100 hover:to-gray-200 transition-colors" :style="{ borderLeftWidth: '4px', borderLeftColor: shift.color }">
        <div class="flex items-center gap-3">
          <i :class="['ti', isShiftCollapsed(shift.id) ? 'ti-chevron-right' : 'ti-chevron-down', 'text-gray-600']"></i>
          <div>
            <h3 class="font-semibold text-gray-900">{{ shift.name }}</h3>
            <p class="text-sm text-gray-500">{{ shift.start_time }} - {{ shift.end_time }}</p>
          </div>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-semibold text-white" :style="{ backgroundColor: shift.color }">
          {{ shift.doctors.length }} {{ shift.doctors.length === 1 ? 'Doctor' : 'Doctors' }}
        </span>
      </div>

      <!-- Horizontal Timeline -->
      <div v-show="!isShiftCollapsed(shift.id)" class="overflow-x-auto" style="overflow-y: visible;">
        <!-- Empty State with Skeleton -->
        <div v-if="shift.doctors.length === 0" class="p-8">
          <div class="flex flex-col items-center gap-4 text-center">
            <!-- Animated Icon -->
            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center animate-pulse">
              <i class="ti ti-calendar-off text-4xl text-gray-400"></i>
            </div>
            
            <!-- Message -->
            <div class="space-y-2">
              <p class="text-gray-600 font-semibold text-base">Tidak ada jadwal dokter</p>
              <p class="text-sm text-gray-500">Belum ada dokter yang terjadwal pada shift ini</p>
            </div>
            
            <!-- Skeleton Cards -->
            <div class="w-full max-w-2xl mt-4 space-y-3">
              <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg animate-pulse">
                <div class="w-12 h-12 rounded-full bg-gray-200"></div>
                <div class="flex-1 space-y-2">
                  <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                  <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                </div>
              </div>
              <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg animate-pulse">
                <div class="w-12 h-12 rounded-full bg-gray-200"></div>
                <div class="flex-1 space-y-2">
                  <div class="h-4 bg-gray-200 rounded w-2/3"></div>
                  <div class="h-3 bg-gray-200 rounded w-1/3"></div>
                </div>
              </div>
              <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg animate-pulse">
                <div class="w-12 h-12 rounded-full bg-gray-200"></div>
                <div class="flex-1 space-y-2">
                  <div class="h-4 bg-gray-200 rounded w-4/5"></div>
                  <div class="h-3 bg-gray-200 rounded w-2/5"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Timeline Grid -->
        <div v-else class="timeline-grid" :style="getGridStyle(shift)">
          <!-- Time Header -->
          <div class="timeline-header-cell">
            <span class="text-sm font-semibold text-gray-700">Dokter</span>
          </div>
          <div v-for="hour in getHoursForShift(shift)" :key="`header-${hour.hour}`" class="timeline-time-cell">
            <span class="text-xs font-semibold text-gray-600">{{ hour.label }}</span>
          </div>

          <!-- Doctor Rows -->
          <template v-for="(doctor, index) in shift.doctors" :key="doctor.id">
            <!-- Doctor Name Column -->
            <div :class="['timeline-doctor-cell', index % 2 === 0 ? 'bg-white' : 'bg-gray-50/50']">
              <img :src="doctor.foto || 'https://i.pravatar.cc/150?img=1'" :alt="doctor.nama" class="w-9 h-9 rounded-full object-cover flex-shrink-0" />
              <div class="flex-1 min-w-0">
                <div class="text-sm font-semibold text-gray-900 truncate">{{ doctor.nama }}</div>
                <div class="text-xs text-gray-500 truncate">{{ doctor.spesialisasi }}</div>
              </div>
            </div>

            <!-- Timeline Cells -->
            <div v-for="hour in getHoursForShift(shift)" :key="`${doctor.id}-${hour.hour}`" :class="['timeline-track-cell', index % 2 === 0 ? 'bg-white' : 'bg-gray-50/50']">
              <div v-for="event in getEventsForDoctorAtHour(doctor.id, hour.hour, shift)" :key="event.id" :style="getEventPositionInCell(event, shift)" class="timeline-event">
                 <div :class="['event-card', getEventClass(event.status)]" @click="showDetail(event)">
                  <div class="w-1.5 h-1.5 rounded-full flex-shrink-0" :class="getDotClass(event.status)"></div>
                  <span class="text-xs font-medium">{{ event.pasien.nama }}</span>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>

    <!-- Detail Modal -->
    <div v-if="showDetailDialog" class="modal-overlay" @click="closeDialog">
      <div class="modal-container" @click.stop>
        <div class="modal-header">
          <h3 class="modal-title">Detail Antrean</h3>
          <button @click="closeDialog" class="modal-close-btn">
            <i class="ti ti-x text-xl"></i>
          </button>
        </div>
        
        <div v-if="selectedEvent" class="modal-body">
          <div class="modal-field">
            <label class="modal-label">Nama Pasien</label>
            <p class="modal-value font-semibold">{{ selectedEvent.pasien.nama }}</p>
          </div>
          
          <div class="modal-field">
            <label class="modal-label">Dokter</label>
            <p class="modal-value">{{ selectedEvent.dokter.nama }}</p>
          </div>
          
          <div class="modal-field">
            <label class="modal-label">Keluhan</label>
            <p class="modal-value">{{ selectedEvent.keluhan || '-' }}</p>
          </div>
          
          <div class="modal-grid">
            <div class="modal-field">
              <label class="modal-label">Jam Kunjungan</label>
              <p class="modal-value">{{ selectedEvent.jam_kunjungan.substring(0, 5) }}</p>
            </div>
            <div class="modal-field">
              <label class="modal-label">No. Registrasi</label>
              <p class="modal-value">{{ selectedEvent.no_registrasi }}</p>
            </div>
          </div>
          
          <div class="modal-field">
            <label class="modal-label">Status</label>
            <span :class="['modal-badge', getStatusBadgeClass(selectedEvent.status)]">
              {{ selectedEvent.status.charAt(0).toUpperCase() + selectedEvent.status.slice(1) }}
            </span>
          </div>
        </div>
        
        <div class="modal-footer">
          <button @click="closeDialog" class="modal-btn-close">
            Tutup
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({
  selectedDate: Date,
  initialAntreans: Array,
  initialShifts: Array,
  initialDoktersByShift: Object
})

const emit = defineEmits(['dateChanged'])

const currentDate = ref(props.selectedDate || new Date())
const selectedEvent = ref(null)
const showDetailDialog = ref(false)
const antreans = ref(props.initialAntreans || [])
const shifts = ref(props.initialShifts || [])
const doktersByShift = ref(props.initialDoktersByShift || {})
const loading = ref(false)
const collapsedShifts = ref({})

const formattedDate = computed(() => {
  return currentDate.value.toLocaleDateString('id-ID', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
})

const formatDateForAPI = (date) => {
  const year = date.getFullYear()
  const month = String(date.getMonth() + 1).padStart(2, '0')
  const day = String(date.getDate()).padStart(2, '0')
  return `${year}-${month}-${day}`
}

const fetchDataForDate = async (date) => {
  loading.value = true
  try {
    const formattedDate = formatDateForAPI(date)
    const response = await axios.get('/antrean-v2', {
      params: { date: formattedDate },
      headers: { 'Accept': 'application/json' }
    })
    
    antreans.value = response.data.antreans
    shifts.value = response.data.shifts
    doktersByShift.value = response.data.doktersByShift
  } catch (error) {
    console.error('Error fetching data:', error)
  } finally {
    loading.value = false
  }
}

watch(() => props.selectedDate, (newDate, oldDate) => {
  if (newDate && newDate !== oldDate) {
    currentDate.value = newDate
    fetchDataForDate(newDate)
  }
})

onMounted(() => {
  if (!props.initialShifts || props.initialShifts.length === 0) {
    fetchDataForDate(currentDate.value)
  }
})

const shiftsWithDoctors = computed(() => {
  return shifts.value.map(shift => ({
    ...shift,
    doctors: doktersByShift.value[shift.id] || []
  }))
})

const toggleShift = (shiftId) => {
  collapsedShifts.value[shiftId] = !collapsedShifts.value[shiftId]
}

const isShiftCollapsed = (shiftId) => {
  return collapsedShifts.value[shiftId] || false
}

const getHoursForShift = (shift) => {
  const startHour = parseInt(shift.start_time.split(':')[0])
  const endHour = parseInt(shift.end_time.split(':')[0])
  const hourCount = endHour - startHour
  
  return Array.from({ length: hourCount }, (_, i) => {
    const hour = startHour + i
    return { hour, label: `${String(hour).padStart(2, '0')}:00` }
  })
}

const getGridStyle = (shift) => {
  const hours = getHoursForShift(shift)
  return {
    gridTemplateColumns: `224px repeat(${hours.length}, 1fr)`
  }
}

const getEventsForDoctorAtHour = (doctorId, hour, shift) => {
  const shiftStartHour = parseInt(shift.start_time.split(':')[0])
  const shiftEndHour = parseInt(shift.end_time.split(':')[0])
  
  return antreans.value.filter(a => {
    if (a.dokter_id !== doctorId) return false
    
    // Use jam_mulai if available, otherwise jam_kunjungan
    const startTime = a.jam_mulai || a.jam_kunjungan
    const eventHour = parseInt(startTime.split(':')[0])
    
    return eventHour === hour && eventHour >= shiftStartHour && eventHour < shiftEndHour
  }).sort((a, b) => {
    const aStart = a.jam_mulai || a.jam_kunjungan
    const bStart = b.jam_mulai || b.jam_kunjungan
    return aStart.localeCompare(bStart)
  })
}

const getEventPositionInCell = (event, shift) => {
  // Use jam_mulai and jam_selesai if available
  const startTime = event.jam_mulai || event.jam_kunjungan
  const endTime = event.jam_selesai || event.jam_kunjungan
  
  const [startHour, startMinute] = startTime.split(':').map(Number)
  const [endHour, endMinute] = endTime.split(':').map(Number)
  
  // Calculate position within the hour cell (0-100%)
  const minutePercent = (startMinute / 60) * 100
  
  // Calculate duration in minutes
  const startTotalMinutes = startHour * 60 + startMinute
  const endTotalMinutes = endHour * 60 + endMinute
  const durationMinutes = endTotalMinutes - startTotalMinutes
  
  // Calculate width as percentage of one hour cell
  // If duration spans multiple hours, it will overflow to next cells
  const widthPercent = (durationMinutes / 60) * 100
  
  // Z-index based on start minute to prevent overlap
  const zIndex = 10 + startMinute
  
  return {
    left: `${minutePercent}%`,
    width: `${widthPercent}%`,
    top: '50%',
    transform: 'translateY(-50%)',
    zIndex: zIndex
  }
}

const getEventClass = (status) => {
  if (status === 'menunggu') return 'event-waiting'
  if (status === 'dipanggil') return 'event-ongoing'
  return 'event-completed'
}

const getDotClass = (status) => {
  if (status === 'menunggu') return 'bg-yellow-500'
  if (status === 'dipanggil') return 'bg-blue-500'
  return 'bg-green-500'
}

const getStatusBadgeClass = (status) => {
  if (status === 'menunggu') return 'bg-yellow-100 text-yellow-800'
  if (status === 'dipanggil') return 'bg-blue-100 text-blue-800'
  return 'bg-green-100 text-green-800'
}

const showDetail = (event) => {
  selectedEvent.value = event
  showDetailDialog.value = true
}

const closeDialog = () => {
  showDetailDialog.value = false
  selectedEvent.value = null
}

const goToPreviousDay = () => {
  const newDate = new Date(currentDate.value)
  newDate.setDate(newDate.getDate() - 1)
  currentDate.value = newDate
  fetchDataForDate(newDate)
  emit('dateChanged', newDate)
}

const goToNextDay = () => {
  const newDate = new Date(currentDate.value)
  newDate.setDate(newDate.getDate() + 1)
  currentDate.value = newDate
  fetchDataForDate(newDate)
  emit('dateChanged', newDate)
}

const goToToday = () => {
  const newDate = new Date()
  currentDate.value = newDate
  fetchDataForDate(newDate)
  emit('dateChanged', newDate)
}
</script>

<style scoped>
.timeline-grid {
  display: grid;
  min-width: 1200px;
  border-collapse: collapse;
  overflow: visible;
}

.timeline-header-cell {
  background: linear-gradient(to right, rgb(249 250 251), rgb(243 244 246));
  border-right: 1px solid rgb(229 231 235);
  border-bottom: 1px solid rgb(229 231 235);
  padding: 10px 16px;
  display: flex;
  align-items: center;
  background-color: white;
  overflow: visible;
}

.timeline-time-cell {
  background: linear-gradient(to right, rgb(249 250 251), rgb(243 244 246));
  border-right: 1px solid rgb(229 231 235);
  border-bottom: 1px solid rgb(229 231 235);
  padding: 10px 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  overflow: visible;
}

.timeline-doctor-cell {
  border-right: 1px solid rgb(229 231 235);
  border-bottom: 1px solid rgb(229 231 235);
  padding: 10px 16px;
  display: flex;
  align-items: center;
  gap: 12px;
  min-height: 64px;
  overflow: visible;
}

.timeline-track-cell {
  border-right: 1px solid rgb(229 231 235);
  border-bottom: 1px solid rgb(229 231 235);
  position: relative;
  min-height: 64px;
  overflow: visible;
}

.timeline-event {
  position: absolute;
  padding: 0;
  z-index: 10;
  overflow: visible;
  pointer-events: auto;
}

.event-card {
  height: 32px;
  border-radius: 6px;
  padding: 0 10px;
  display: flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  transition: all 0.2s;
  border-width: 1px;
  border-style: solid;
  box-sizing: border-box;
  white-space: nowrap;
  overflow: hidden;
  position: relative;
  z-index: 10;
  min-width: 60px;
  pointer-events: auto;
}

.event-card span {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  flex: 1;
  min-width: 0;
}

.event-card:hover {
  box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
  transform: scale(1.02);
  z-index: 100 !important;
}

.event-waiting {
  background-color: rgb(254 249 195);
  border-color: rgb(253 224 71);
  color: rgb(113 63 18);
}

.event-waiting:hover {
  background-color: rgb(254 240 138);
}

.event-ongoing {
  background-color: rgb(219 234 254);
  border-color: rgb(147 197 253);
  color: rgb(30 58 138);
}

.event-ongoing:hover {
  background-color: rgb(191 219 254);
}

.event-completed {
  background-color: rgb(220 252 231);
  border-color: rgb(134 239 172);
  color: rgb(20 83 45);
}

.event-completed:hover {
  background-color: rgb(187 247 208);
}

/* Modal Styles */
.modal-overlay {
  position: fixed;
  inset: 0;
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: rgba(0, 0, 0, 0.5);
  padding: 16px;
}

.modal-container {
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  max-width: 500px;
  width: 100%;
  max-height: calc(100vh - 48px);
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 24px;
  border-bottom: 1px solid rgb(229 231 235);
}

.modal-title {
  font-size: 18px;
  font-weight: 600;
  color: rgb(17 24 39);
  margin: 0;
}

.modal-close-btn {
  color: rgb(156 163 175);
  background: none;
  border: none;
  cursor: pointer;
  padding: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 4px;
  transition: all 0.2s;
}

.modal-close-btn:hover {
  color: rgb(75 85 99);
  background-color: rgb(243 244 246);
}

.modal-body {
  padding: 24px;
  overflow-y: auto;
  flex: 1;
}

.modal-field {
  margin-bottom: 16px;
}

.modal-field:last-child {
  margin-bottom: 0;
}

.modal-label {
  display: block;
  font-size: 14px;
  font-weight: 500;
  color: rgb(107 114 128);
  margin-bottom: 4px;
}

.modal-value {
  font-size: 16px;
  color: rgb(17 24 39);
  margin: 0;
}

.modal-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
  margin-bottom: 16px;
}

.modal-badge {
  display: inline-block;
  padding: 6px 12px;
  border-radius: 9999px;
  font-size: 12px;
  font-weight: 600;
}

.modal-footer {
  padding: 16px 24px;
  border-top: 1px solid rgb(229 231 235);
  display: flex;
  justify-content: flex-end;
}

.modal-btn-close {
  padding: 10px 20px;
  background-color: rgb(6 182 212);
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.2s;
}

.modal-btn-close:hover {
  background-color: rgb(8 145 178);
}
</style>
