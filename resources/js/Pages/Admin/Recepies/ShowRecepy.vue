<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import GoBackButton from "@/Components/GoBackButton.vue";

const props = defineProps({
  recepy: Object,
});
</script>
<template>
  <Head :title="`Dettagli ricetta: ${recepy.name}`" />

  <MainLayout>
    <div class="d-flex justify-content-between align-items-center">
      <h2>Dettagli ricetta: {{ recepy.name }}</h2>
      <GoBackButton />
    </div>
    <div class="card mt-3">
      <div class="card-body">
        <div v-if="recepy.description !== null" class="mb-3">
          <h5 class="card-title">Descrizione</h5>
          <p class="card-text">{{ recepy.description }}</p>
        </div>
        <div class="mb-3">
          <h5 class="card-title">Prezzo</h5>
          <p class="card-text">{{ recepy.price }} €</p>
        </div>
        <div class="mb-3">
          <h5 class="card-title">Ingredienti</h5>
          <table class="table">
            <thead>
              <tr>
                <th>Prodotto</th>
                <th>Grammi utilizzati</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in recepy.products" :key="product.id">
                <td>{{ product.name }}</td>
                <td>{{ product.pivot.grams_used }} g</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </MainLayout>
</template>
<style lang=""></style>
