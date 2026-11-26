<template>
  <div class="space-y-4">
    <!-- Loading Modal -->
    <div v-if="loading" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
      <div class="bg-white rounded-lg shadow-xl p-8 flex flex-col items-center gap-4">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-cyan-500"></div>
        <p class="text-gray-700 font-medium">Loading data...</p>
      </div>
    </div>

    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
      <div class="flex items-center gap-2">
        <button @click="goToPreviousMonth" class="btn btn-sm btn-outline-secondary">
          <i class="ti ti-chevron-left"></i>
        </button>
        <button @click="goToToday" class="btn btn-sm btn-primary">Hari Ini</button>
        <button @click="goToNextMonth" class="btn btn-sm btn-outline-secondary">
          <i class="ti ti-chevron-right"></i>
        </button>
      </div>
      <h2 class="text-lg font-semibold">{{ monthName }}</h2>
    </div>

    <!-- Calendar Grid -->
    <div class="calendar-container">
      <!-- Day Headers -->
      <div class="calendar-header">
        <div v-for="day in dayHeaders" :key="day" class="calendar-header-cell">
          {{ day }}
        </div>
      </div>

      <!-- Calendar Body -->
      <div class="calendar-body">
        <!-- Empty cells for days before month starts -->
        <div v-for="i in firstDayOfMonth" :key="`empty-${i}`" class="calendar-cell calendar-cell-empty"></div>

        <!-- Days of month -->
        <div v-for="day in daysInMonth" :key="day" class="calendar-cell" @click="handleDateClick(day)">
          <div class="calendar-cell-header">
            <span :class="['calendar-date', isToday(day) ? 'calendar-date-today' : '']">
              {{ day }}
            </span>
            
            <!-- Booking count badge -->
            <span v-if="monthEvents[day] && monthEvents[day].length > 0" class="calendar-badge">
              {{ monthEvents[day].length }}
            </span>
          </div>

          <!-- Events -->
          <div class="calendar-events">
            <div v-for="(event, index) in getSortedEvents(day).slice(0, 3)" :key="event.id" :class="['calendar-event', getEventClass(event.status)]">
              {{ event.pasien.nama }}
            </div>

            <!-- Show more indicator -->
            <div v-if="monthEvents[day] && monthEvents[day].length > 3" class="calendar-more">
              +{{ monthEvents[day].length - 3 }} more
            </div>
          </div>
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

const emit = defineEmits(['switchToDay', 'dateSelected'])

const currentDate = ref(props.selectedDate || new Date())
const allAntreans = ref([])
const loading = ref(false)

const dayHeaders = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']

const currentMonth = computed(() => currentDate.value.getMonth())
const currentYear = computed(() => currentDate.value.getFullYear())

const daysInMonth = computed(() => {
  return new Date(currentYear.value, currentMonth.value + 1, 0).getDate()
})

const firstDayOfMonth = computed(() => {
  return new Date(currentYear.value, currentMonth.value, 1).getDay()
})

const fetchMonthData = async () => {
  loading.value = true
  try {
    const firstDay = new Date(currentYear.value, currentMonth.value, 1)
    const lastDay = new Date(currentYear.value, currentMonth.value + 1, 0)
    
    const promises = []
    for (let d = new Date(firstDay); d <= lastDay; d.setDate(d.getDate() + 1)) {
      const dateStr = formatDateForAPI(new Date(d))
      promises.push(
        axios.get('/antrean-v2', {
          params: { date: dateStr },
          headers: { 'Accept': 'application/json' }
        }).then(res => res.data.antreans)
      )
    }
    
    const results = await Promise.all(promises)
    allAntreans.value = results.flat()
  } catch (error) {
    console.error('Error fetching month data:', error)
  } finally {
    loading.value = false
  }
}

const formatDateForAPI = (date) => {
  const year = date.getFullYear()
  const month = String(date.getMonth() + 1).padStart(2, '0')
  const day = String(date.getDate()).padStart(2, '0')
  return `${year}-${month}-${day}`
}

watch([currentMonth, currentYear], () => {
  fetchMonthData()
})

onMounted(() => {
  fetchMonthData()
})

const monthEvents = computed(() => {
  const eventsByDay = {}
  
  for (let day = 1; day <= daysInMonth.value; day++) {
    eventsByDay[day] = allAntreans.value.filter(a => {
      const eventDate = new Date(a.tanggal_kunjungan)
      return eventDate.getDate() === day && 
             eventDate.getMonth() === currentMonth.value && 
             eventDate.getFullYear() === currentYear.value
    })
  }
  
  return eventsByDay
})

const getSortedEvents = (day) => {
  const events = monthEvents.value[day] || []
  return events.sort((a, b) => {
    return a.jam_kunjungan.localeCompare(b.jam_kunjungan)
  })
}

const monthName = computed(() => {
  return currentDate.value.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })
})

const isToday = (day) => {
  const today = new Date()
  return day === today.getDate() && 
         currentMonth.value === today.getMonth() && 
         currentYear.value === today.getFullYear()
}

const getEventClass = (status) => {
  if (status === 'menunggu') return 'event-waiting'
  if (status === 'dipanggil') return 'event-ongoing'
  return 'event-completed'
}

const handleDateClick = (day) => {
  const clickedDate = new Date(currentYear.value, currentMonth.value, day)
  emit('dateSelected', clickedDate)
  emit('switchToDay')
}

const goToPreviousMonth = () => {
  const newDate = new Date(currentDate.value)
  newDate.setMonth(newDate.getMonth() - 1)
  currentDate.value = newDate
}

const goToNextMonth = () => {
  const newDate = new Date(currentDate.value)
  newDate.setMonth(newDate.getMonth() + 1)
  currentDate.value = newDate
}

const goToToday = () => {
  currentDate.value = new Date()
}
</script>

<style scoped>
.calendar-container {
  border: 1px solid rgb(229 231 235);
  border-radius: 8px;
  background: white;
  overflow: hidden;
}

.calendar-header {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  background: rgb(249 250 251);
  border-bottom: 1px solid rgb(229 231 235);
}

.calendar-header-cell {
  padding: 8px;
  text-align: center;
  font-size: 0.875rem;
  font-weight: 500;
  color: rgb(75 85 99);
  border-right: 1px solid rgb(229 231 235);
}

.calendar-header-cell:last-child {
  border-right: none;
}

.calendar-body {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
}

.calendar-cell {
  min-height: 120px;
  border-right: 1px solid rgb(229 231 235);
  border-bottom: 1px solid rgb(229 231 235);
  padding: 8px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.calendar-cell:hover {
  background-color: rgb(249 250 251);
}

.calendar-cell:nth-child(7n) {
  border-right: none;
}

.calendar-cell-empty {
  background-color: rgb(249 250 251);
  cursor: default;
}

.calendar-cell-empty:hover {
  background-color: rgb(249 250 251);
}

.calendar-cell-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 8px;
}

.calendar-date {
  font-size: 0.875rem;
  font-weight: 500;
  color: rgb(17 24 39);
}

.calendar-date-today {
  background-color: rgb(6 182 212);
  color: white;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.calendar-badge {
  font-size: 0.75rem;
  background-color: rgb(6 182 212);
  color: white;
  padding: 2px 8px;
  border-radius: 9999px;
  font-weight: 600;
}

.calendar-events {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.calendar-event {
  font-size: 0.75rem;
  padding: 4px 8px;
  border-radius: 4px;
  cursor: pointer;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  color: white;
  transition: opacity 0.2s;
}

.calendar-event:hover {
  opacity: 0.8;
}

.event-waiting {
  background-color: rgb(234 179 8);
}

.event-ongoing {
  background-color: rgb(59 130 246);
}

.event-completed {
  background-color: rgb(34 197 94);
}

.calendar-more {
  font-size: 0.75rem;
  color: rgb(107 114 128);
  padding: 0 8px;
  cursor: pointer;
}

.calendar-more:hover {
  color: rgb(55 65 81);
}
</style>
