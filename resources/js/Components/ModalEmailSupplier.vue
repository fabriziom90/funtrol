<script setup>
import { ref, defineEmits, computed } from "vue";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";

const props = defineProps({
  showModal: Boolean,
  product: Object,
  allProducts: Array,
});

const $toast = useToast();

const emit = defineEmits(["close"]);

const supplierProducts = computed(() => {
  if (!props.product) return [];

  return props.allProducts.filter((p) => p.supplier_id === props.product.supplier_id);
});

const lowStockProducts = computed(() => {
  return supplierProducts.value.filter((p) => p.grams_in_warehouse < p.min_stock);
});

const mailBody = computed({
  get() {
    if (!props.product) return "";

    if (lowStockProducts.value.length === 0) {
      return "";
    }

    const supplierName = props.product.supplier.name;

    let lines = `Gentile ${supplierName},\n`;
    lines += `Si richiede il riordino urgente dei seguenti prodotti:\n`;

    lowStockProducts.value.forEach((p) => {
      const toOrder = Math.max(p.min_stock - p.grams_in_warehouse, 0);
      const unit = p.unit ?? "g";

      lines += `- ${p.name} (${toOrder}${unit} necessari)\n`;
    });

    lines += `\nCordiali Saluti,\nFunTrol Operatore`;

    return lines;
  },
  set() {},
});

const isLoading = ref(false);

const handleSubmit = () => {
  isLoading.value = true;
  router.post(
    route("warehouse.send-supplier-mail"),
    {
      to: props.product.supplier.email,
      subject: "Ordine urgente prodotti",
      body: mailBody.value,
    },
    {
      preserveScroll: true,
      onSuccess: () => {
        isLoading.value = false;
        $toast.success("Email inviata con successo!", {
          position: "top-right",
          duration: 3000,
        });
        emit("close");
      },
      onError: () => {
        isLoading.value = false;
      },
    }
  );
};
</script>
<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-header">
            <h2>
              <i class="fa-solid fa-triangle-exclamation fa-2xl me-2"></i>Ordina prodotti
            </h2>
          </div>
          <div class="modal-body">
            {{
              lowStockProducts.length > 0
                ? "La produzione giornaliera ha portato i seguenti prodotti sotto la soglia minima di riordino per il corrispettivo fornitore:"
                : ""
            }}
            <div class="alert alert-danger mt-2" v-if="lowStockProducts.length > 0">
              <ul class="list-unstyled m-0">
                <li
                  v-for="p in lowStockProducts"
                  :key="p.id"
                  class="d-flex justify-content-between align-items-center"
                >
                  <span>{{ p.name }}</span>
                  <strong>
                    {{ p.grams_in_warehouse }}{{ p.unit }} (soglia: {{ p.min_stock
                    }}{{ p.unit }})
                  </strong>
                </li>
              </ul>
            </div>
            <div class="textarea-container">
              <textarea
                name=""
                id=""
                class="form-control"
                v-model="mailBody"
                rows="10"
              ></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button class="secondary-button me-2" @click="$emit('close')">Annulla</button>
            <button class="main-button" @click="handleSubmit" :disabled="isLoading">
              <span v-if="!isLoading"
                ><i class="fa-regular fa-paper-plane"></i>Invia Ordine
              </span>
              <span v-else>
                <i class="fa-solid fa-circle-notch fa-spin"></i>Invio...</span
              >
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>
<style lang="scss" scoped>
@use "../../scss/app.scss";
@use "../../scss/_partials/variables" as *;
.modal-header {
  color: $mainRed;

  h2 {
    font-size: 20px;
  }
}

.list-unstyled strong {
  color: $mainRed;
}
</style>
