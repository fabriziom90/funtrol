<script setup>
import { ref } from "vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import GoBackButton from "@/Components/GoBackButton.vue";
import { useToast } from "vue-toast-notification";

const props = defineProps({
  product: Object,
  suppliers: Array,
});

const $toast = useToast();

const form = useForm({
  name: props.product.name,
  price: props.product.price,
  supplier_id: props.product.supplier_id,
  grams_in_warehouse: props.product.grams_in_warehouse,
});

const handleSubmitForm = () => {
  form.put(route("admin.products.update", { product: props.product.id }), {
    onSuccess: (page) => {
      const toast = page.props.toast;
      if (toast) {
        $toast.success(toast.message, {
          position: "top-right",
          duration: 3000,
        });
      }
    },
    onError: (err) => {
      console.log(err);
    },
  });
};
</script>
<template>
  <Head title="Crea prodotto" />
  <MainLayout>
    <div class="d-flex justify-content-between align-items-center">
      <h2>Crea nuovo prodotto</h2>
      <GoBackButton />
    </div>
    <form @submit.prevent="handleSubmitForm">
      <div class="row gy-4 mt-1">
        <div class="col-12 col-md-4">
          <label for="" class="form-label">Nome</label>
          <input
            type="text"
            class="form-control"
            :class="form.errors.name ? 'is-invalid' : ''"
            placeholder="Inserisci nome"
            v-model="form.name"
          />
          <div v-if="form.errors.name" class="text-danger">
            {{ form.errors.name }}
          </div>
        </div>
        <div class="col-12 col-md-4">
          <label for="" class="form-label">Prezzo</label>
          <input
            type="number"
            min="0"
            step="0.01"
            class="form-control"
            :class="form.errors.price ? 'is-invalid' : ''"
            placeholder="Inserisci Prezzo"
            v-model="form.price"
          />
          <div v-if="form.errors.price" class="text-danger">
            {{ form.errors.price }}
          </div>
        </div>
        <div class="col-12 col-md-4">
          <label for="" class="form-label">Fornitore</label>
          <select
            v-model="form.supplier_id"
            class="form-select"
            :class="form.errors.supplier_id ? 'is-invalid' : ''"
          >
            <option value="">Seleziona fornitore</option>
            <option :value="supplier.id" v-for="supplier in props.suppliers">
              {{ supplier.name }}
            </option>
          </select>
          <div v-if="form.errors.supplier_id" class="text-danger">
            {{ form.errors.supplier_id }}
          </div>
        </div>
        <div class="col-12 col-md-4">
          <label for="" class="form-label">Grammi in magazzino</label>
          <input
            type="number"
            min="0"
            v-model="form.grams_in_warehouse"
            placeholder="Grammi in magazzino"
            class="form-control"
            :class="form.errors.grams_in_warehouse ? 'is-invalid' : ''"
          />
          <div v-if="form.errors.grams_in_warehouse" class="text-danger">
            {{ form.errors.grams_in_warehouse }}
          </div>
        </div>
        <div class="col-12">
          <button class="main-button">Salva</button>
        </div>
      </div>
    </form>
  </MainLayout>
</template>
<style lang=""></style>
