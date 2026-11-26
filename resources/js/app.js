import { createApp } from 'vue'
import AntreanScheduler from './components/AntreanScheduler.vue'
import AntreanSchedulerV2 from './components/AntreanSchedulerV2.vue'

if (document.getElementById('antrean-scheduler')) {
    const app = createApp(AntreanScheduler, {
        antreans: window.antreans || [],
        dokters: window.dokters || []
    })
    app.mount('#antrean-scheduler')
}

if (document.getElementById('antrean-scheduler-v2')) {
    const app = createApp(AntreanSchedulerV2, {
        antreans: window.antreansV2 || [],
        shifts: window.shiftsV2 || [],
        doktersByShift: window.doktersByShiftV2 || {}
    })
    app.mount('#antrean-scheduler-v2')
}

