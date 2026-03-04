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
  products: Object,
  columns: Array,
  filters: Object,
  stores: Object,
});

const $toast = useToast();

const showModal = ref(false);
const productToDelete = ref(null);
const storeFilter = ref(props.filters.store || "");

const editProduct = (productId) => {
  router.visit(route("admin.products.edit", productId));
};

const deleteProduct = (product) => {
  showModal.value = true;
  productToDelete.value = product;
};

const closeDeleteModal = () => {
  productToDelete.value = null;
  showModal.value = false;
};

const handleDeleted = (toast) => {
  $toast.success(toast.message, {
    position: "top-right",
    duration: 3000,
  });
};

const applyFilter = () => {
  router.get(
    route("admin.products.index"),
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
  <Head title="Amministrazione Prodotti" />
  <MainLayout>
    <div class="my-3">
      <div class="d-flex admin-page-header">
        <AdminMenu />
        <GoBackButton />
      </div>
      <div class="d-flex justify-content-between align-items-center">
        <h2>Gestione Prodotti</h2>
        <Link :href="route('admin.products.create')" class="main-button">
          Crea prodotto
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
        :items="products.data"
        :show-view="false"
        :show-edit="true"
        :show-delete="true"
        baseRoute="admin.products"
        @edit="editProduct"
        @delete="deleteProduct"
      >
      </Table>
    </div>
    <div class="mt-4 d-flex justify-content-center">
      <button
        v-for="link in products.links"
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
      :item="productToDelete"
      baseRoute="admin.products"
      @close="closeDeleteModal"
      @deleted="handleDeleted"
    />
  </MainLayout>
</template>
<style lang="scss" scoped></style>
