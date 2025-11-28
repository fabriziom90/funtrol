<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import GoBackButton from "@/Components/GoBackButton.vue";
import AdminMenu from "@/Components/AdminMenu.vue";
import Table from "@/Components/Table.vue";
import ModalDelete from "@/Components/ModalDelete.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";

const props = defineProps({
    suppliers: Array,
    columns: Array,
});

const $toast = useToast();

const showModal = ref(false);
const supplierToDelete = ref(null);

const editSupplier = (supplierId) => {
    router.visit(route("admin.suppliers.edit", supplierId));
};

const deleteSupplier = (supplier) => {
    showModal.value = true;
    supplierToDelete.value = supplier;
};

const closeDeleteModal = () => {
    supplierToDelete.value = null;
    showModal.value = false;
};

const handleDeleted = (toast) => {
    console.log(toast);
    $toast.success(toast.message, {
        position: "top-right",
        duration: 3000,
    });
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
                <h2>Gestione Fornitori</h2>
                <Link
                    :href="route('admin.suppliers.create')"
                    class="main-button"
                >
                    Crea fornitore
                </Link>
            </div>
        </div>
        <div>
            <Table
                :headers="columns"
                :items="suppliers"
                :show-view="false"
                :show-edit="true"
                :show-delete="true"
                baseRoute="admin.suppliers"
                @view="viewUser"
                @edit="editSupplier"
                @delete="deleteSupplier"
            >
            </Table>
        </div>
        <ModalDelete
            :show="showModal"
            :item="supplierToDelete"
            baseRoute="admin.suppliers"
            @close="closeDeleteModal"
            @deleted="handleDeleted"
        />
    </MainLayout>
</template>
<style lang="scss" scoped></style>
