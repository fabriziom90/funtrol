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
  suppliers: Object,
  filters: Object,
  stores: Array,
  columns: Array,
});

const $toast = useToast();

const showModal = ref(false);
const supplierToDelete = ref(null);
const storeFilter = ref(props.filters.store || "");

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

const applyFilter = () => {
  router.get(
    route("admin.suppliers.index"),
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
  <Head title="Amministrazione Fornitori" />
  <MainLayout>
    <div class="my-3">
      <div class="d-flex admin-page-header">
        <AdminMenu />
        <GoBackButton />
      </div>
      <div class="d-flex justify-content-between align-items-center">
        <h2>Gestione Fornitori</h2>
        <Link :href="route('admin.suppliers.create')" class="main-button">
          Crea fornitore
        </Link>
      </div>
    </div>
    <div>
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
        :items="suppliers.data"
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
    <div class="mt-4 d-flex justify-content-center">
      <button
        v-for="link in suppliers.links"
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
      :item="supplierToDelete"
      baseRoute="admin.suppliers"
      @close="closeDeleteModal"
      @deleted="handleDeleted"
    />
  </MainLayout>
</template>
<style lang="scss" scoped></style>
