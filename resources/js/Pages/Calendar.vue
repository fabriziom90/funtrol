<script setup>
import "vue-cal/dist/vuecal.css";
import VueCal from "vue-cal";
import { ref } from "vue";

const events = ref([
    { start: "2025-11-12", end: "2025-11-12", title: "Evento demo" },
]);
</script>

<template>
    <div class="row gy-3">
        <div class="col-12">
            <h2>
                <i class="fas fa-calendar-days fa-xl"></i>
                Calendario (Storico)
            </h2>
        </div>
        <div class="col-12">
            <vue-cal
                :hideViewSelector="true"
                locale="it"
                activeView="month"
                :views="['month']"
                :time="false"
                :events="events"
                :minCellWidth="100"
            />
        </div>
    </div>
</template>

<style lang="scss" scoped>
@use "../../scss/_partials/variables" as *;
h2 {
    color: $mainBlue;
}

.fc {
    --fc-border-color: #ddd;
    --fc-button-bg-color: #0066cc;
    --fc-button-text-color: white;
    --fc-button-hover-bg-color: #0051a8;
    --fc-today-bg-color: rgba(0, 102, 204, 0.1);
}

.vuecal__month-cell {
    height: 120px; /* altezza personalizzata */
}
</style>
