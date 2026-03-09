<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();

const logout = () => {
  router.post(route("logout"));
};
</script>
<template>
  <Head title="Amministrazione" />
  <MainLayout>
    <div class="d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center">
        <i class="fas fa-gear fa-xl me-2"></i>
        <h2>Area Amministrativa</h2>
      </div>

      <button class="main-button" @click="logout">
        <i class="fas fa-right-from-bracket me-1"></i> Logout
      </button>
    </div>
    <div class="mt-4">
      <h3>Gestione dati di base, accesso riservato:</h3>
    </div>
    <div class="mt-4" id="sections">
      <Link
        :href="route('admin.stores.index')"
        class="card-section"
        v-if="page.props.auth.user.role === 'superadmin'"
      >
        Gestione Negozi
      </Link>
      <Link :href="route('products.index')" class="card-section">
        Gestione Prodotti
      </Link>
      <Link :href="route('recepies.index')" class="card-section"> Gestione Ricette </Link>
      <Link :href="route('suppliers.index')" class="card-section">
        Gestione Fornitori
      </Link>
      <Link :href="route('orders.index')" class="card-section"> Gestione Ordini </Link>
    </div>
  </MainLayout>
</template>
<style lang="scss" scoped>
@use "../../../scss/app.scss";
@use "../../../scss/_partials/variables" as *;

h3 {
  font-weight: 300;
}

.card-section {
  border: 1px solid #e5e7eb;
  border-radius: 10px;
  background-color: #e5e7eb;
  width: 100%;
  display: block;
  padding: 15px 10px;
  cursor: pointer;
  transition: 0.3s;
  margin: 10px 0px;

  &:hover {
    background-color: $mainBlue;
    color: #fff;
  }
}
</style>
