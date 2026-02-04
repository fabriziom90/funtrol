<script setup>
import { Head } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import GoBackButton from "@/Components/GoBackButton.vue";
import AdminMenu from "@/Components/AdminMenu.vue";
import Table from "@/Components/Table.vue";
import ModalDelete from "@/Components/ModalDelete.vue";
import { ref } from "vue";
import { useToast } from "vue-toast-notification";

const props = defineProps({
  orders: Array,
  columns: Array,
});

const $toast = useToast();

const showModal = ref(false);
const orderToDelete = ref(null);

const deleteOrder = (order) => {
  showModal.value = true;
  orderToDelete.value = order;
};

const closeDeleteModal = () => {
  showModal.value = false;
  orderToDelete.value = null;
};

const handleDeleted = (toast) => {
  $toast.success(toast.message, {
    position: "top-right",
    duration: 3000,
  });
};
</script>
<template>
  <Head title="Gestione ordini" />
  <MainLayout>
    <div class="my-3">
      <div class="d-flex admin-page-header"><AdminMenu /><GoBackButton /></div>
      <div class="d-flex">
        <h2>Gestione Ordini</h2>
      </div>
    </div>

    <Table
      :headers="columns"
      :items="orders"
      :show-view="false"
      :show-edit="false"
      :show-delete="true"
      baseRoute="admin.orders"
      @delete="deleteOrder"
    >
    </Table>
    <ModalDelete
      :show="showModal"
      :item="orderToDelete"
      baseRoute="admin.orders"
      @close="closeDeleteModal"
      @deleted="handleDeleted"
    />
  </MainLayout>
</template>
<style lang="scss" scoped></style>
