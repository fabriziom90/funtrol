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
  products: Array,
  columns: Array,
});

const $toast = useToast();

const showModal = ref(false);
const productToDelete = ref(null);

const editProduct = (productId) => {
  router.visit(route("admin.products.edit", productId));
};

const deleteProduct = (Product) => {
  showModal.value = true;
  productToDelete.value = Product;
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
</script>
<template>
  <Head title="Amministrazione Prodotti" />
  <MainLayout>
    <div class="my-3">
      <div class="d-flex justify-content-between align-items-center">
        <AdminMenu /> <GoBackButton />
      </div>
      <div class="d-flex justify-content-between align-items-center">
        <h2>Gestione Prodotti</h2>
        <Link :href="route('admin.products.create')" class="main-button">
          Crea prodotto
        </Link>
      </div>
    </div>
    <div>
      <Table
        :headers="columns"
        :items="products"
        :show-view="false"
        :show-edit="true"
        :show-delete="true"
        baseRoute="admin.products"
        @edit="editProduct"
        @delete="deleteProduct"
      >
      </Table>
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
