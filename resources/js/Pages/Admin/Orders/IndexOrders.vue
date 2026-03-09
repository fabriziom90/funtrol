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
  orders: Object,
  columns: Array,
  stores: Array,
  filters: Object,
});

const $toast = useToast();

const showModal = ref(false);
const orderToDelete = ref(null);
const storeFilter = ref(props.filters.store || "");

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

const applyFilter = () => {
  router.get(
    route("orders.index"),
    {
      store: storeFilter.value,
    },
    {
      preserveState: true,
      replace: true,
    }
  );
};
</script>
<template>
  <Head title="Gestione ordini" />
  <MainLayout>
    <div class="my-3">
      <div class="d-flex admin-page-header">
        <AdminMenu />
        <GoBackButton />
      </div>
      <div class="d-flex">
        <h2>Gestione Ordini</h2>
      </div>
    </div>
    <div class="mb-3">
      <select v-model="storeFilter" @change="applyFilter" class="form-select w-auto">
        <option value="">Tutti i negozi</option>
        <option v-for="store in stores" :key="store.id" :value="store.id">
          {{ store.name }}
        </option>
      </select>
    </div>
    <Table
      :headers="columns"
      :items="orders.data"
      :show-view="false"
      :show-edit="false"
      :show-delete="true"
      baseRoute="orders"
      @delete="deleteOrder"
    >
    </Table>
    <div class="mt-4 d-flex justify-content-center">
      <button
        v-for="link in orders.links"
        :key="link.label"
        v-html="link.label"
        :disabled="!link.url"
        @click="link.url && router.visit(link.url)"
        class="btn btn-sm mx-1"
        :class="{
          'btn-primary': link.active,
          'btn-outline-primary': !link.active,
        }"
      />
    </div>
    <ModalDelete
      :show="showModal"
      :item="orderToDelete"
      baseRoute="orders"
      @close="closeDeleteModal"
      @deleted="handleDeleted"
    />
  </MainLayout>
</template>
<style lang="scss" scoped></style>
