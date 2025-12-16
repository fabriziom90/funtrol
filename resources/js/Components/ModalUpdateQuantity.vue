<script setup>
import { ref, defineEmits } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";

const props = defineProps({
  showModal: Boolean,
  product: Object,
});

const emit = defineEmits(["close", "update"]);

const $toast = useToast();
const page = usePage();

const form = useForm({
  grams_in_warehouse: 0,
});

const isLoading = ref(false);

const handleSubmit = () => {
  isLoading.value = true;
  form.put(
    route("warehouse.update-product-quantity", {
      product: props.product.id,
    }),
    {
      preserveScroll: true,
      onSuccess: () => {
        isLoading.value = false;
        emit("update");
        emit("close");
        const toast = page.props.toast;

        if (toast) {
          $toast.success(toast.message, {
            position: "top-right",
            duration: 3000,
          });
        }
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
            <h2>Aggiorna quantità</h2>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Quantità</label>
              <input
                type="number"
                class="form-control"
                v-model="form.grams_in_warehouse"
              />
            </div>
          </div>
          <div class="modal-footer">
            <button class="secondary-button me-2" @click="$emit('close')">Annulla</button>
            <button class="main-button" @click="handleSubmit" :disabled="isLoading">
              <span v-if="!isLoading">Aggiorna quantità </span>
              <span v-else>
                <i class="fa-solid fa-circle-notch fa-spin"></i>Aggiornamento...</span
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
</style>
