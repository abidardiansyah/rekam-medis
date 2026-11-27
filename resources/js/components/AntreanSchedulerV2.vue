<template>
  <div class="space-y-6">
    <!-- View Switcher -->
    <div class="card">
      <div class="card-body">
        <div class="flex items-center justify-between mb-4">
          <div class="flex items-center gap-3">
            <h3 class="text-lg font-semibold">Timeline Antrean</h3>
            <span class="px-3 py-1 text-xs font-semibold bg-cyan-100 text-cyan-800 rounded-full">
              V2 - Experimental
            </span>
          </div>
          <div class="flex gap-2">
            <button @click="currentView = 'day'" :class="['btn btn-sm', currentView === 'day' ? 'btn-primary' : 'btn-outline-secondary']">
              <i class="ti ti-calendar-event"></i> Day
            </button>
            <button @click="currentView = 'month'" :class="['btn btn-sm', currentView === 'month' ? 'btn-primary' : 'btn-outline-secondary']">
              <i class="ti ti-calendar"></i> Month
            </button>
          </div>
        </div>

        <!-- Day View -->
        <AntreanDayView v-if="currentView === 'day'" :selectedDate="selectedDate" :initialAntreans="antreans" :initialShifts="shifts" :initialDoktersByShift="doktersByShift" @dateChanged="fetchDataForDate" />

        <!-- Month View -->
        <AntreanMonthView v-if="currentView === 'month'" :selectedDate="selectedDate" @switchToDay="switchToDay" @dateSelected="handleDateSelected" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import AntreanDayView from './AntreanDayView.vue'
import AntreanMonthView from './AntreanMonthView.vue'

const props = defineProps({
  antreans: Array,
  shifts: Array,
  doktersByShift: Object
})

const currentView = ref('day')
const selectedDate = ref(new Date())

const handleDateSelected = (date) => {
  selectedDate.value = date
}

const switchToDay = () => {
  currentView.value = 'day'
}

const fetchDataForDate = (date) => {
  selectedDate.value = date
}
</script>
