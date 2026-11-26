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
      <div class="px-6 py-3 border-b flex items-center justify-between bg-gradient-to-r from-gray-50 to-gray-100" :style="{ borderLeftWidth: '4px', borderLeftColor: shift.color }">
        <div>
          <h3 class="font-semibold text-gray-900">{{ shift.name }}</h3>
          <p class="text-sm text-gray-500">{{ shift.start_time }} - {{ shift.end_time }}</p>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-semibold text-white" :style="{ backgroundColor: shift.color }">
          {{ shift.doctors.length }} {{ shift.doctors.length === 1 ? 'Doctor' : 'Doctors' }}
        </span>
      </div>

      <!-- Horizontal Timeline -->
      <div class="overflow-x-auto">
        <!-- Empty State Skeleton -->
        <div v-if="shift.doctors.length === 0" class="p-8 text-center">
          <div class="flex flex-col items-center gap-3">
            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
              <i class="ti ti-calendar-off text-3xl text-gray-400"></i>
            </div>
            <p class="text-gray-500 font-medium">Tidak ada jadwal dokter</p>
            <p class="text-sm text-gray-400">Belum ada dokter yang terjadwal pada shift ini</p>
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
                  <span class="text-xs font-medium truncate">{{ event.pasien.nama }}</span>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>

    <!-- Detail Modal -->
    <div v-if="showDetailDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click="closeDialog">
      <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6" @click.stop>
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Detail Antrean</h3>
          <button @click="closeDialog" class="text-gray-400 hover:text-gray-600">
            <i class="ti ti-x text-xl"></i>
          </button>
        </div>
        
        <div v-if="selectedEvent" class="space-y-4">
          <div>
            <label class="text-sm font-medium text-gray-500">Nama Pasien</label>
            <p class="text-base font-semibold text-gray-900">{{ selectedEvent.pasien.nama }}</p>
          </div>
          
          <div>
            <label class="text-sm font-medium text-gray-500">Dokter</label>
            <p class="text-base text-gray-900">{{ selectedEvent.dokter.nama }}</p>
          </div>
          
          <div>
            <label class="text-sm font-medium text-gray-500">Keluhan</label>
            <p class="text-base text-gray-900">{{ selectedEvent.keluhan }}</p>
          </div>
          
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="text-sm font-medium text-gray-500">Jam Kunjungan</label>
              <p class="text-base text-gray-900">{{ selectedEvent.jam_kunjungan.substring(0, 5) }}</p>
            </div>
            <div>
              <label class="text-sm font-medium text-gray-500">No. Registrasi</label>
              <p class="text-base text-gray-900">{{ selectedEvent.no_registrasi }}</p>
            </div>
          </div>
          
          <div>
            <label class="text-sm font-medium text-gray-500">Status</label>
            <span :class="['inline-block px-3 py-1 rounded-full text-xs font-semibold', getStatusBadgeClass(selectedEvent.status)]">
              {{ selectedEvent.status.charAt(0).toUpperCase() + selectedEvent.status.slice(1) }}
            </span>
          </div>
        </div>
        
        <div class="mt-6 flex justify-end">
          <button @click="closeDialog" class="px-4 py-2 bg-cyan-500 text-white rounded-md hover:bg-cyan-600 transition-colors">
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
  selectedDate: Date
})

const emit = defineEmits(['dateChanged'])

const currentDate = ref(props.selectedDate || new Date())
const selectedEvent = ref(null)
const showDetailDialog = ref(false)
const antreans = ref([])
const shifts = ref([])
const doktersByShift = ref({})
const loading = ref(false)

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

watch(() => props.selectedDate, (newDate) => {
  if (newDate) {
    currentDate.value = newDate
    fetchDataForDate(newDate)
  }
}, { immediate: true })

onMounted(() => {
  fetchDataForDate(currentDate.value)
})

const shiftsWithDoctors = computed(() => {
  return shifts.value.map(shift => ({
    ...shift,
    doctors: doktersByShift.value[shift.id] || []
  }))
})

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
    const eventHour = parseInt(a.jam_kunjungan.split(':')[0])
    return eventHour === hour && eventHour >= shiftStartHour && eventHour < shiftEndHour
  }).sort((a, b) => a.jam_kunjungan.localeCompare(b.jam_kunjungan))
}

const getEventPositionInCell = (event, shift) => {
  const [hour, minute] = event.jam_kunjungan.split(':').map(Number)
  const minutePercent = (minute / 60) * 100
  const duration = 20
  const widthPercent = (duration / 60) * 100
  
  // Z-index based on minute - later appointments have higher z-index
  const zIndex = 10 + minute
  
  return {
    left: `${minutePercent}%`,
    width: `${Math.min(widthPercent, 100 - minutePercent)}%`,
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
}

.timeline-header-cell {
  background: linear-gradient(to right, rgb(249 250 251), rgb(243 244 246));
  border-right: 1px solid rgb(229 231 235);
  border-bottom: 1px solid rgb(229 231 235);
  padding: 10px 16px;
  display: flex;
  align-items: center;
  background-color: white;
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
}

.timeline-doctor-cell {
  border-right: 1px solid rgb(229 231 235);
  border-bottom: 1px solid rgb(229 231 235);
  padding: 10px 16px;
  display: flex;
  align-items: center;
  gap: 12px;
  min-height: 64px;
}

.timeline-track-cell {
  border-right: 1px solid rgb(229 231 235);
  border-bottom: 1px solid rgb(229 231 235);
  position: relative;
  min-height: 64px;
}

.timeline-event {
  position: absolute;
  padding: 0;
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
</style>
