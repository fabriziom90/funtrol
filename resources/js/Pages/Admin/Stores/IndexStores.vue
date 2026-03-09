<script setup>
import { ref, computed } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import { router } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import GoBackButton from "@/Components/GoBackButton.vue";
import AdminMenu from "@/Components/AdminMenu.vue";
import Table from "@/Components/Table.vue";
import ModalDelete from "@/Components/ModalDelete.vue";

const props = defineProps({
  users: Object,
  columns: Array,
});

const $toast = useToast();

const showModal = ref(false);
const storeToDelete = ref(null);
const search = ref("");

const editStore = (storeId) => {
  router.visit(route("admin.stores.edit", storeId));
};

const showStore = (storeId) => {
  router.visit(route("admin.stores.show", storeId));
};

const deleteStore = (store) => {
  showModal.value = true;
  storeToDelete.value = store;
};

const closeDeleteModal = () => {
  storeToDelete.value = null;
  showModal.value = false;
};

const handleDeleted = (toast) => {
  $toast.success(toast.message, {
    position: "top-right",
    duration: 3000,
  });
};

const filteredStores = computed(() => {
  if (search.value === "") return props.users.data;

  return props.users.data.filter((user) =>
    user.store.name.toLowerCase().includes(search.value.toLowerCase())
  );
});
</script>
<template>
  <Head title="Amministrazione negozi"></Head>
  <MainLayout>
    <div class="my-3">
      <div class="d-flex admin-page-header">
        <AdminMenu />
        <GoBackButton />
      </div>
      <div class="d-flex justify-content-between align-items-center">
        <h2>Gestione Negozi</h2>
        <Link :href="route('admin.stores.create')" class="main-button">
          Crea Negozio
        </Link>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-12">
        <input
          type="text"
          class="form-control"
          placeholder="Cerca negozio..."
          v-model="search"
        />
      </div>
    </div>
    <div>
      <Table
        :headers="columns"
        :items="filteredStores"
        :show-view="false"
        :show-edit="true"
        :show-delete="true"
        baseRoute="admin.store"
        @view="showStore"
        @edit="editStore"
        @delete="deleteStore"
      >
      </Table>
    </div>
    <div class="mt-4 d-flex justify-content-center">
      <button
        v-for="link in users.links"
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
      :item="storeToDelete"
      baseRoute="admin.stores"
      @close="closeDeleteModal"
      @deleted="handleDeleted"
    />
  </MainLayout>
</template>
<style lang="scss" scoped></style>
