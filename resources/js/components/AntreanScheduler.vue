<template>
  <div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
      <div class="card bg-gradient-to-br from-cyan-500 to-teal-500">
        <div class="card-body px-4 py-3">
          <div class="flex items-start justify-between">
            <div class="space-y-1.5">
              <p class="text-sm text-white/80">Total Antrean</p>
              <p class="text-2xl font-semibold text-white">{{ stats.total }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
              <i class="ti ti-users text-white text-xl"></i>
            </div>
          </div>
        </div>
      </div>
      
      <div class="card bg-gradient-to-br from-amber-500 to-orange-500">
        <div class="card-body px-4 py-3">
          <div class="flex items-start justify-between">
            <div class="space-y-1.5">
              <p class="text-sm text-white/80">Menunggu</p>
              <p class="text-2xl font-semibold text-white">{{ stats.menunggu }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
              <i class="ti ti-clock text-white text-xl"></i>
            </div>
          </div>
        </div>
      </div>
      
      <div class="card bg-gradient-to-br from-blue-500 to-indigo-500">
        <div class="card-body px-4 py-3">
          <div class="flex items-start justify-between">
            <div class="space-y-1.5">
              <p class="text-sm text-white/80">Dipanggil</p>
              <p class="text-2xl font-semibold text-white">{{ stats.dipanggil }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
              <i class="ti ti-phone text-white text-xl"></i>
            </div>
          </div>
        </div>
      </div>
      
      <div class="card bg-gradient-to-br from-green-500 to-emerald-500">
        <div class="card-body px-4 py-3">
          <div class="flex items-start justify-between">
            <div class="space-y-1.5">
              <p class="text-sm text-white/80">Selesai</p>
              <p class="text-2xl font-semibold text-white">{{ stats.selesai }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
              <i class="ti ti-check text-white text-xl"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Timeline View -->
    <div class="card">
      <div class="card-body">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold">Timeline Antrean Hari Ini</h3>
          <div class="flex gap-2">
            <button @click="goToPreviousDay" class="btn btn-sm btn-outline-secondary">
              <i class="ti ti-chevron-left"></i>
            </button>
            <button @click="goToToday" class="btn btn-sm btn-primary">Hari Ini</button>
            <button @click="goToNextDay" class="btn btn-sm btn-outline-secondary">
              <i class="ti ti-chevron-right"></i>
            </button>
          </div>
        </div>
        
        <p class="text-sm text-muted mb-4">{{ formattedDate }}</p>

        <!-- Timeline Grid -->
        <div class="overflow-x-auto">
          <div class="min-w-[800px]">
            <!-- Header: Dokter -->
            <div class="grid gap-2 mb-2" :style="gridStyle">
              <div class="font-semibold text-sm p-2 bg-gray-100 rounded">Waktu</div>
              <div v-for="dokter in dokters" :key="dokter.id" class="font-semibold text-sm p-2 bg-cyan-50 rounded text-center">
                {{ dokter.nama }}
                <div class="text-xs text-muted font-normal">{{ dokter.spesialisasi }}</div>
              </div>
            </div>

            <!-- Timeline Rows -->
            <div v-for="hour in hours" :key="hour" class="grid gap-2 mb-1" :style="gridStyle">
              <div class="text-sm p-2 bg-gray-50 rounded font-medium">{{ hour }}</div>
              <div v-for="dokter in dokters" :key="dokter.id" class="relative min-h-[80px] bg-white border border-gray-200 rounded p-1">
                <div v-for="antrean in getAntreansForDokterAtHour(dokter.id, hour)" :key="antrean.id" 
                     class="absolute left-1 right-1 p-2 rounded text-xs cursor-pointer hover:shadow-md transition-shadow"
                     :class="getStatusClass(antrean.status)"
                     :style="getEventPosition(antrean.jam_kunjungan)"
                     @click="showDetail(antrean)">
                  <div class="font-semibold">{{ antrean.pasien.nama }}</div>
                  <div class="text-xs opacity-80">{{ antrean.jam_kunjungan.substring(0, 5) }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  antreans: Array,
  dokters: Array
})

const currentDate = ref(new Date())

const stats = computed(() => ({
  total: props.antreans.length,
  menunggu: props.antreans.filter(a => a.status === 'menunggu').length,
  dipanggil: props.antreans.filter(a => a.status === 'dipanggil').length,
  selesai: props.antreans.filter(a => a.status === 'selesai').length
}))

const hours = computed(() => {
  const result = []
  for (let h = 7; h < 19; h++) {
    result.push(`${String(h).padStart(2, '0')}:00`)
  }
  return result
})

const gridStyle = computed(() => ({
  gridTemplateColumns: `120px repeat(${props.dokters.length}, 1fr)`
}))

const formattedDate = computed(() => {
  return currentDate.value.toLocaleDateString('id-ID', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
})

const getAntreansForDokterAtHour = (dokterId, hour) => {
  return props.antreans.filter(a => {
    if (a.dokter_id !== dokterId) return false
    const jamHour = a.jam_kunjungan.substring(0, 2)
    return jamHour === hour.substring(0, 2)
  })
}

const getStatusClass = (status) => {
  if (status === 'menunggu') return 'bg-amber-100 text-amber-800 border-l-4 border-amber-500'
  if (status === 'dipanggil') return 'bg-blue-100 text-blue-800 border-l-4 border-blue-500'
  return 'bg-green-100 text-green-800 border-l-4 border-green-500'
}

const goToPreviousDay = () => {
  const newDate = new Date(currentDate.value)
  newDate.setDate(newDate.getDate() - 1)
  currentDate.value = newDate
}

const goToNextDay = () => {
  const newDate = new Date(currentDate.value)
  newDate.setDate(newDate.getDate() + 1)
  currentDate.value = newDate
}

const goToToday = () => {
  currentDate.value = new Date()
}

const getEventPosition = (jamKunjungan) => {
  const [hour, minute] = jamKunjungan.split(':').map(Number)
  const minutePercent = (minute / 60) * 100
  return {
    top: `${minutePercent}%`,
    height: '25px'
  }
}

const showDetail = (antrean) => {
  console.log('Show detail:', antrean)
  // TODO: Open modal
}
</script>
