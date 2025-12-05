<script setup>
import { ref } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import { router } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import GoBackButton from "@/Components/GoBackButton.vue";
import AdminMenu from "@/Components/AdminMenu.vue";
import Table from "@/Components/Table.vue";
import ModalDelete from "@/Components/ModalDelete.vue";

const props = defineProps({
  recepies: Array,
  columns: Array,
});

const $toast = useToast();

const showModal = ref(false);
const recepyToDelete = ref(null);

const editRecepy = (recepyId) => {
  router.visit(route("admin.recepies.edit", recepyId));
};

const showRecepy = (recepyId) => {
  router.visit(route("admin.recepies.show", recepyId));
};

const deleteRecepy = (recepy) => {
  showModal.value = true;
  recepyToDelete.value = recepy;
};

const closeDeleteModal = () => {
  recepyToDelete.value = null;
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
  <Head title="Amministrazione Ricette" />
  <MainLayout>
    <div class="my-3">
      <div class="d-flex justify-content-between align-items-center">
        <AdminMenu /> <GoBackButton />
      </div>
      <div class="d-flex justify-content-between align-items-center">
        <h2>Gestione Ricette</h2>
        <Link :href="route('admin.recepies.create')" class="main-button">
          Crea Ricetta
        </Link>
      </div>
    </div>
    <div>
      <Table
        :headers="columns"
        :items="recepies"
        :show-view="true"
        :show-edit="true"
        :show-delete="true"
        baseRoute="admin.recepies"
        @view="showRecepy"
        @edit="editRecepy"
        @delete="deleteRecepy"
      >
      </Table>
    </div>
    <ModalDelete
      :show="showModal"
      :item="recepyToDelete"
      baseRoute="admin.recepies"
      @close="closeDeleteModal"
      @deleted="handleDeleted"
    />
  </MainLayout>
</template>
<style lang="scss" scoped></style>
