<script setup>
import { Head } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import "../../../node_modules/vue-cal/dist/vue-cal.css";
import { VueCal } from "vue-cal";
import { ref, watchEffect } from "vue";

const props = defineProps({
  warehouseMovements: Array,
});

const movements = ref([]);
const showModal = ref(false);
const selectedEvent = ref(null);

watchEffect(() => {
  movements.value = props.warehouseMovements.map((event) => {
    const start = new Date(event.start);
    const end = new Date(event.end);

    return {
      id: event.id,
      start: start, // oggetto Date in locale
      end: end,
      title: event.title,
      class: event.class,
      details: event.details,
    };
  });
});

const onEventClick = ({ event }) => {
  const found = movements.value.find((e) => e.id === event.id);
  console.log(found);
  selectedEvent.value = found;
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  selectedEvent.value = null;
};
</script>

<template>
  <Head title="Calendario" />
  <MainLayout>
    <div class="row gy-3">
      <div class="col-12">
        <h2>
          <i class="fas fa-calendar-days fa-xl"></i>
          Calendario (Storico)
        </h2>
      </div>

      <div class="col-12">
        <vue-cal
          style="height: 900px"
          :hideViewSelector="true"
          locale="it"
          active-view="month"
          events-on-month-view
          :views="['month']"
          :time="false"
          :today-button="false"
          :cell-height="150"
          :events="movements"
          event-class="class"
          @event-click="onEventClick"
        />
      </div>
      <div v-if="showModal" class="modal-backdrop" @click.self="closeModal">
        <div class="modal-content">
          <h3>{{ selectedEvent?.title }}</h3>
          <p><strong>Totale quantità:</strong> {{ selectedEvent?.total_quantity }}</p>
          <table>
            <thead>
              <tr>
                <th>Ingrediente</th>
                <th>Quantità (g)</th>
                <th>Prima (g)</th>
                <th>Dopo (g)</th>
                <th>€ Spesa in prodotti</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(d, i) in selectedEvent.details" :key="i" :class="d.row_class">
                <td>{{ d.product }}</td>
                <td>{{ d.quantity }}</td>
                <td>{{ d.before_quantity }}</td>
                <td>{{ d.after_quantity }}</td>
                <td>{{ d.spent }} €</td>
              </tr>
            </tbody>
          </table>
          <button class="main-button mt-3" @click="closeModal">Chiudi</button>
        </div>
      </div>
    </div>
  </MainLayout>
</template>

<style lang="scss" scoped>
@use "../../scss/app.scss" as *;
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

.vuecal__month-view .vuecal__cell {
  min-height: 160px;
}

.vuecal__month-view .vuecal__cell-content {
  height: 100%;
}

.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  max-width: 800px;
  width: 90%;
}
.modal-content table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}
.modal-content th,
.modal-content td {
  border: 1px solid #ccc;
  padding: 4px 8px;
  text-align: left;
}

.row-out {
  background-color: #ffe5e5;
}

.row-in {
  background-color: #e6f7e6;
}
</style>
