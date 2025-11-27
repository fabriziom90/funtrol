<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
</script>
<template lang="">
    <Head title="Amministrazione" />
    <MainLayout>
        <div class="d-flex align-items-center">
            <i class="fas fa-gear fa-xl me-2"></i>
            <h2>Area Amministrativa</h2>
        </div>
        <div class="mt-4">
            <h3>Gestione dati di base, accesso riservato:</h3>
        </div>
        <div class="mt-4" id="sections">
            <Link :href="route('admin.products.index')" class="card-section">
                Gestione Prodotti
            </Link>
            <Link class="card-section"> Gestione Ricette </Link>
            <Link :href="route('admin.suppliers.index')" class="card-section">
                Gestione Fornitori
            </Link>
            <Link class="card-section"> Storico Prezzi </Link>
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
