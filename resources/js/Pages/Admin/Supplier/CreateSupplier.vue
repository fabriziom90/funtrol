<script setup>
import { ref } from "vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import GoBackButton from "@/Components/GoBackButton.vue";
import { useToast } from "vue-toast-notification";

const $toast = useToast();

const form = useForm({
    name: "",
    email: "",
    phone: "",
});

const handleSubmitForm = () => {
    form.post(route("admin.suppliers.store"), {
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
<template lang="">
    <Head title="Crea fornitore" />
    <MainLayout>
        <div class="d-flex justify-content-between align-items-center">
            <h2>Crea nuovo fornitore</h2>
            <GoBackButton />
        </div>
        <form @submit.prevent="handleSubmitForm">
            <div class="row gy-4 mt-1">
                <div class="col-12 col-md-4">
                    <label for="" class="form-label">Nome</label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Inserisci nome"
                        v-model="form.name"
                    />
                </div>
                <div class="col-12 col-md-4">
                    <label for="" class="form-label">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        placeholder="Inserisci Email"
                        v-model="form.email"
                    />
                </div>
                <div class="col-12 col-md-4">
                    <label for="" class="form-label">Telefono</label>
                    <input
                        type="phone"
                        class="form-control"
                        placeholder="Inserisci Telefono"
                        v-model="form.phone"
                    />
                </div>
                <div class="col-12">
                    <button class="main-button">Salva</button>
                </div>
            </div>
        </form>
    </MainLayout>
</template>
<style lang=""></style>
