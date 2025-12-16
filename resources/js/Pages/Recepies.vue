<script setup>
import { Head, usePage, useForm } from "@inertiajs/vue3";
import { ref, reactive } from "vue";
import Alert from "../Components/Alert.vue";
import ModalEmailSupplier from "../Components/ModalEmailSupplier.vue";
import MainLayout from "@/Layouts/MainLayout.vue";

const props = defineProps({
  recepies: Array,
  message: String,
  success: Boolean,
  critical_count: Number,
});

const productionQuantities = reactive({});

props.recepies.forEach((item) => {
  productionQuantities[item.id] = 0;
});

const showMessage = ref(false);
const isLoading = ref(false);
const isModalOpen = ref(false);

const form = useForm({
  quantities: productionQuantities,
});

const showModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};

const handleSubmit = () => {
  isLoading.value = true;

  const payload = props.recepies.map((r) => ({
    recepy_id: r.id,
    quantity: productionQuantities[r.id],
  }));

  form.quantities = payload;

  form.put(route("production.update"), {
    preserveScroll: true, // Evita di tornare in alto
    preserveState: true, // Mantiene i dati attuali dei props/form
    onSuccess: (page) => {
      isLoading.value = false;

      // Recupera il toast/props aggiornati dopo la richiesta
      if (page.props.success) {
        showMessage.value = true;
      }
    },
    onError: () => {
      isLoading.value = false;
    },
  });
};
</script>
<template>
  <Head title="Produzione" />
  <MainLayout>
    <div class="row gy-3">
      <div class="col-12">
        <h2><i class="fas fa-utensils fa-xl"></i> Produzione giornaliera</h2>
        <p class="pt-3">
          Registra le ricette in data
          {{ new Date().toLocaleDateString() }}
        </p>
      </div>

      <div class="col-12" v-for="(recepy, index) in recepies" :key="recepy.id">
        <div class="card">
          <div class="d-flex justify-content-between align-items-center p-4">
            <div>
              <h4>{{ recepy.name }}</h4>
              <p>Unità: {{ recepy.unit }}</p>
            </div>
            <div class="input-container">
              <input
                type="number"
                name=""
                id=""
                class="form-control"
                placeholder="0"
                v-model="productionQuantities[recepy.id]"
              />
              <label for="" class="form-label ms-2">{{ recepy.unit }}</label>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <button class="main-button w-100" @click="handleSubmit" :disabled="isLoading">
          <span v-if="!isLoading"
            >Registra Produzione
            <span class="icon-content"><i class="fas fa-check"></i></span
          ></span>
          <span v-else
            ><i class="fa-solid fa-circle-notch fa-spin"></i>Caricamento...</span
          >
        </button>
      </div>
      <Alert
        v-if="success"
        type="success"
        message="Produzione registrata con successo"
        classes="text-center fw-700"
        :event="false"
      />
      <Alert
        v-if="critical_count > 0"
        type="danger"
        :message="`Genera Ordine Urgente. Ci sono ${critical_count} prodotti sotto la soglia minima di magazzino`"
        classes="text-center fw-700"
        :eventAlert="true"
      />
    </div>
  </MainLayout>
</template>
<style lang="scss" scoped>
@use "../../scss/app.scss";
@use "../../scss/_partials/variables" as *;

h2 {
  color: $mainBlue;
}

.input-container {
  display: flex;
  align-items: center;

  input {
    width: 100px;
    height: 50px;
  }
}

.main-button .input-content {
  border: 3px solid #fff;
  border-radius: 50%;
  width: 30px;
  height: 30px;
  display: inline-block;
  text-align: center;
  font-size: 16px;
}
</style>
