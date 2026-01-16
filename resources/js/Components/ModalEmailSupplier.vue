<script setup>
import { ref, defineEmits, computed, watchEffect, watch } from "vue";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";

const props = defineProps({
  showModal: Boolean,
  product: Object,
  allProducts: Array,
  authUser: Object,
});

const $toast = useToast();

const emit = defineEmits(["close"]);

const supplierProducts = ref([]);
const mailPreview = ref("");

const lowStockProducts = computed(() => {
  return supplierProducts.value.filter((p) => p.grams_in_warehouse < p.min_stock);
});

const isFormValid = computed(() => {
  return lowStockProducts.value.every(
    (p) => Number.isInteger(p.qty_to_order) && p.qty_to_order > 0
  );
});

watchEffect(() => {
  if (!props.product) return;

  supplierProducts.value = props.allProducts
    .filter((p) => p.supplier_id === props.product.supplier_id)
    .map((p) => ({
      ...p,
      qty_to_order: Math.max(p.min_stock - p.grams_in_warehouse, 0),
    }));
});

watchEffect(() => {
  if (!props.product || lowStockProducts.value.length === 0) return;

  let text = `Gentile ${props.product.supplier.name},\n`;
  text += `Si richiede il riordino urgente dei seguenti prodotti:\n`;

  lowStockProducts.value.forEach((p) => {
    text += `- ${p.name}: ${p.qty_to_order} g\n`;
  });

  text += `\nCordiali saluti,\n${props.authUser.name}`;

  mailPreview.value = text;
});

// watch(
//   () => lowStockProducts.value.map((p) => p.qty_to_order),
//   () => {
//     let text = `Gentile ${props.product.supplier.name},\n`;
//     text += `Si richiede il riordino urgente dei seguenti prodotti:\n`;
//     lowStockProducts.value.forEach((p) => {
//       text += `- ${p.name}: ${p.qty_to_order} g\n`;
//     });
//     text += `\nCordiali saluti,\n${props.authUser.name}`;
//     mailPreview.value = text;
//   }
// );

const isLoading = ref(false);

const handleSubmit = () => {
  if (!isFormValid.value) {
    $toast.error("Inserisci una quantità valida per tutti i prodotti");
    return;
  }
  // isLoading.value = true;
  router.post(
    route("warehouse.send-supplier-mail"),
    {
      supplier_id: props.product.supplier_id,
      to: props.product.supplier.email,
      subject: "Ordine prodotti",
      body: mailPreview.value,
      products: lowStockProducts.value.map((p) => ({
        product_id: p.id,
        unit_price: p.price,
        quantity: p.qty_to_order,
      })),
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
                  class="d-flex justify-content-between align-items-center my-3"
                >
                  <span>{{ p.name }}</span>
                  <strong>
                    {{ p.grams_in_warehouse }}{{ p.unit }} (soglia: {{ p.min_stock
                    }}{{ p.unit }})
                  </strong>
                  <input
                    type="number"
                    min="0"
                    :placeholder="`Quantità ${p.name}`"
                    class="form-control w-50"
                    v-model="p.qty_to_order"
                    required
                  />
                </li>
              </ul>
            </div>
            <div class="textarea-container">
              <label for="">Anteprima email (generata automaticamente)</label>
              <textarea
                name=""
                id=""
                class="form-control readonly-preview"
                :value="mailPreview"
                rows="10"
                readonly
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

.readonly-preview {
  background-color: #e9ecef;
  cursor: not-allowed;
}
</style>
