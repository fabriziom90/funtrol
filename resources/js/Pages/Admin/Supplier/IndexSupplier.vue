<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import GoBackButton from "@/Components/GoBackButton.vue";
import AdminMenu from "@/Components/AdminMenu.vue";
import Table from "@/Components/Table.vue";
import { ref } from "vue";

const props = defineProps({
    suppliers: Array,
    columns: Array,
});

const viewUser = () => {
    console.log("view user");
};

const editUser = () => {
    console.log("edit user");
};

const deleteUser = () => {
    console.log("delete user");
};
</script>
<template lang="">
    <Head title="Amministrazione Prodotti" />
    <MainLayout>
        <div class="my-3">
            <div class="d-flex justify-content-between align-items-center">
                <AdminMenu /> <GoBackButton />
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <h2>Gestione prodotti</h2>
            </div>
        </div>
        <div>
            <Table
                :headers="columns"
                :items="suppliers"
                :show-view="true"
                :show-edit="true"
                :show-delete="true"
                @view="viewUser"
                @edit="editUser"
                @delete="deleteUser"
            >
            </Table>
        </div>
    </MainLayout>
</template>
<style lang="scss" scoped></style>
