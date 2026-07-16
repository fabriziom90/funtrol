<script setup>
import { ref, computed } from "vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import GoBackButton from "@/Components/GoBackButton.vue";
import { useToast } from "vue-toast-notification";

const props = defineProps({
    product: Object,
    suppliers: Array,
    stores: Array,
});

const $toast = useToast();

const form = useForm({
    name: props.product.name,
    price: props.product.price,
    supplier_id: props.product.supplier_id,
    grams_in_warehouse: props.product.grams_in_warehouse,
    unit: "g",
    min_stock: props.product.min_stock,
    store_id: props.product.store_id,
});

const handleSubmitForm = () => {
    form.put(route("products.update", { product: props.product.id }), {
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

    <Head title="Modifica prodotto" />
    <MainLayout>
        <div class="d-flex justify-content-between align-items-center">
            <h2>Modifica nuovo prodotto</h2>
            <GoBackButton />
        </div>
        <form @submit.prevent="handleSubmitForm">
            <div class="row gy-4 mt-1">
                <div class="col-12 col-md-4">
                    <label for="" class="form-label">Negozio</label>
                    <select v-model="form.store_id" class="form-select"
                        :class="form.errors.store_id ? 'is-invalid' : ''">
                        <option value="">Seleziona Negozio</option>
                        <option :value="store.id" v-for="store in props.stores">
                            {{ store.name }}
                        </option>
                    </select>
                    <div v-if="form.errors.store_id" class="text-danger">
                        {{ form.errors.store_id }}
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <label for="" class="form-label">Nome</label>
                    <input type="text" class="form-control" :class="form.errors.name ? 'is-invalid' : ''"
                        placeholder="Inserisci nome" v-model="form.name" />
                    <div v-if="form.errors.name" class="text-danger">
                        {{ form.errors.name }}
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <label for="" class="form-label">Prezzo di acquisto</label>
                    <input type="number" min="0" step="0.01" class="form-control"
                        :class="form.errors.price ? 'is-invalid' : ''" placeholder="Inserisci Prezzo di acquisto"
                        v-model="form.price" />
                    <div v-if="form.errors.price" class="text-danger">
                        {{ form.errors.price }}
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <label for="" class="form-label">Fornitore</label>
                    <select v-model="form.supplier_id" class="form-select"
                        :class="form.errors.supplier_id ? 'is-invalid' : ''">
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
                    <label for="" class="form-label">Quantità in magazzino (grammi)</label>
                    <input type="number" min="0" v-model="form.grams_in_warehouse" placeholder="Quantità in magazzino"
                        class="form-control" :class="form.errors.grams_in_warehouse ? 'is-invalid' : ''" />
                    <div v-if="form.errors.grams_in_warehouse" class="text-danger">
                        {{ form.errors.grams_in_warehouse }}
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <label for="" class="form-label">Soglia minima di magazzino (grammi)</label>
                    <input type="number" min="0" v-model="form.min_stock" placeholder="Quantità in magazzino"
                        class="form-control" :class="form.errors.min_stock ? 'is-invalid' : ''" />
                    <div v-if="form.errors.min_stock" class="text-danger">
                        {{ form.errors.min_stock }}
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <!-- <label for="" class="form-label">Unità di misura</label>
                    <input type="text" class="form-control" :class="form.errors.unit ? 'is-invalid' : ''"
                        placeholder="Inserisci unità di misura (es. pezzi, litri)" v-model="form.unit" />
                    <div v-if="form.errors.unit" class="text-danger">
                        {{ form.errors.unit }}
                    </div> -->
                </div>
                <div class="col-12">
                    <button class="main-button">Salva</button>
                </div>
            </div>
        </form>
    </MainLayout>
</template>
<style lang=""></style>
