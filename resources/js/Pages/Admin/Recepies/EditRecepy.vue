<script setup>
import { ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import GoBackButton from "@/Components/GoBackButton.vue";
import { useToast } from "vue-toast-notification";

const props = defineProps({
  recepy: Object,
  products: Array,
});

const $toast = useToast();

const initialIngredients = props.recepy.products.map((p) => ({
  product_id: p.id,
  grams_used: p.pivot.grams_used, // <-- Usa ciò che arriva dal pivot
}));

const form = useForm({
  name: props.recepy.name,
  description: props.recepy.description,
  price: props.recepy.price,
  ingredients: initialIngredients,
});

const addIngredient = () => {
  form.ingredients.push({ product_id: "", grams_used: "" });
};

const removeIngredient = (index) => {
  form.ingredients.splice(index, 1);
};

const hasIngredientError = (index, field) => {
  return form.errors[`ingredients.${index}.${field}`] ? "is-invalid" : "";
};

const handleSubmitForm = () => {
  form.put(route("admin.recepies.update", { recepy: props.recepy.id }), {
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
  <Head title="Modifica ricetta" />
  <MainLayout>
    <div class="d-flex justify-content-between align-items-center">
      <h2>Modifica ricetta</h2>
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
          <label for="" class="form-label">Descrizione</label>
          <input
            type="text"
            class="form-control"
            :class="form.errors.description ? 'is-invalid' : ''"
            placeholder="Inserisci descrizione"
            v-model="form.description"
          />
          <div v-if="form.errors.description" class="text-danger">
            {{ form.errors.description }}
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
      </div>
      <div class="mt-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h5>Ingredienti</h5>
          <button
            type="button"
            class="btn btn-sm btn-outline-primary"
            @click="addIngredient"
          >
            Aggiungi ingrediente
          </button>
        </div>

        <div
          v-for="(ing, index) in form.ingredients"
          :key="index"
          class="row g-2 align-items-end mb-2"
        >
          <div class="col-7 col-md-6">
            <label class="form-label">Prodotto</label>
            <select v-model="form.ingredients[index].product_id" class="form-select">
              <option value="">Seleziona prodotto</option>
              <option v-for="p in props.products" :key="p.id" :value="p.id">
                {{ p.name }}
              </option>
            </select>
          </div>

          <div class="col-3 col-md-4">
            <label class="form-label">Quantità (g)</label>
            <input
              type="number"
              min="0"
              class="form-control"
              :class="hasIngredientError(index, 'grams_used')"
              v-model="form.ingredients[index].grams_used"
              placeholder="Grammi"
            />
            <div
              v-if="form.errors[`ingredients.${index}.grams_used`]"
              class="text-danger"
            >
              {{ form.errors[`ingredients.${index}.grams_used`] }}
            </div>
          </div>

          <div class="col-2 col-md-2 text-end">
            <button
              type="button"
              class="btn btn-sm btn-outline-danger"
              @click="removeIngredient(index)"
              title="Rimuovi"
            >
              &times;
            </button>
          </div>
        </div>
      </div>
      <div class="mt-4">
        <button type="submit" class="main-button">Aggiorna Ricetta</button>
      </div>
    </form>
  </MainLayout>
</template>
<style lang=""></style>
