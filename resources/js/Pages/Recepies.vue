<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import Alert from "../Components/Alert.vue";
import ModalEmailSupplier from "../Components/ModalEmailSupplier.vue";
import MainLayout from "@/Layouts/MainLayout.vue";

const showMessage = ref(false);
const isLoading = ref(false);
const isModalOpen = ref(false);

const recepies = ref([
    {
        id: 1,
        title: "Pizza Margherita",
        unit: "Pz",
    },
    {
        id: 2,
        title: "Pane Casereccio",
        unit: "Kg",
    },
    {
        id: 3,
        title: "Croissant al Cioccolato",
        unit: "Pz",
    },
]);

const handleSubmit = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        showMessage.value = true;
    }, 1500);
};

const showModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};
</script>
<template lang="">
    <Head title="Produzione" />
    <MainLayout>
        <div class="row gy-3">
            <div class="col-12">
                <h2>
                    <i class="fas fa-utensils fa-xl"></i>
                    Produzione giornaliera
                </h2>
                <p class="pt-3">
                    Registra le ricette in data
                    {{ new Date().toLocaleDateString() }}
                </p>
            </div>

            <Alert
                v-if="showMessage"
                type="danger"
                message="Produzione registrata. ATTENZIONE 3 prodotti sono SOTTO SOGLIA"
                :event="false"
            />

            <div class="col-12" v-for="recepy in recepies" :key="recepy.id">
                <div class="card">
                    <div
                        class="d-flex justify-content-between align-items-center p-4"
                    >
                        <div>
                            <h4>{{ recepy.title }}</h4>
                            <p>Unità: {{ recepy.unit }}</p>
                        </div>
                        <div class="input-container">
                            <input
                                type="number"
                                name=""
                                id=""
                                class="form-control"
                                placeholder="0"
                            />
                            <label for="" class="form-label ms-2">{{
                                recepy.unit
                            }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button class="main-button w-100" @click="handleSubmit">
                    <span v-if="!isLoading"
                        >Registra Produzione
                        <span class="icon-content"
                            ><i class="fas fa-check"></i></span
                    ></span>
                    <span v-else
                        ><i class="fa-solid fa-circle-notch fa-spin"></i
                        >Caricamento...</span
                    >
                </button>
            </div>
            <Alert
                v-if="showMessage"
                type="danger"
                message="Genera Ordine Urgente"
                classes="text-center fw-700"
                :event="true"
                @openModal="showModal"
            />
            <ModalEmailSupplier v-if="isModalOpen" @close="closeModal" />
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
