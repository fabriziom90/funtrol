<script setup>
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import GoBackButton from "@/Components/GoBackButton.vue";
import { useToast } from "vue-toast-notification";

const form = useForm({
  store: {
    name: "",
    owner_name: "",
    email: "",
  },
  user: {
    email: "",
    password: "",
  },
});

const $toast = useToast();

const handleSubmitForm = () => {
  form.post(route("admin.stores.store"), {
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
<template>
  <Head title="Crea Negozio" />
  <MainLayout>
    <div class="d-flex justify-content-between align-items-center">
      <h2>Crea nuovo negozio</h2>
      <GoBackButton />
    </div>
    <form @submit.prevent="handleSubmitForm">
      <div class="row gy-2 mt-2">
        <div class="col-12">
          <h2>Informazioni account</h2>
        </div>
        <div class="col-12 col-md-4">
          <label for="" class="form-label">Email account</label>
          <input
            type="email"
            class="form-control"
            placeholder="Email account"
            v-model="form.user.email"
          />
          <div v-if="form.errors['user.email']" class="text-danger">
            {{ form.errors["user.email"] }}
          </div>
        </div>
        <div class="col-12 col-md-4">
          <label for="" class="form-label">Password</label>
          <input
            type="password"
            class="form-control"
            placeholder="Password account"
            v-model="form.user.password"
          />
          <div v-if="form.errors['user.password']" class="text-danger">
            {{ form.errors["user.password"] }}
          </div>
        </div>
      </div>
      <div class="row mt-3 gy-2">
        <div class="col-12">
          <h2>Dettaglio negozio</h2>
        </div>
        <div class="col-12 col-md-4">
          <label for="" class="form-label">Nome negozio</label>
          <input
            type="text"
            class="form-control"
            placeholder="Nome negozio"
            v-model="form.store.name"
          />
          <div v-if="form.errors['store.name']" class="text-danger">
            {{ form.errors["store.name"] }}
          </div>
        </div>
        <div class="col-12 col-md-4">
          <label for="" class="form-label">Nome proprietario</label>
          <input
            type="text"
            class="form-control"
            placeholder="Nome proprietario"
            v-model="form.store.owner_name"
          />
          <div v-if="form.errors['store.owner_name']" class="text-danger">
            {{ form.errors["store.owner_name"] }}
          </div>
        </div>

        <div class="col-12 col-md-4">
          <label for="" class="form-label">Email negozio</label>
          <input
            type="email"
            class="form-control"
            placeholder="Email account"
            v-model="form.store.email"
          />
          <div v-if="form.errors['store.email']" class="text-danger">
            {{ form.errors["store.email"] }}
          </div>
        </div>
      </div>
      <div class="mt-4">
        <button type="submit" class="main-button">Crea Negozio</button>
      </div>
    </form>
  </MainLayout>
</template>
<style lang="scss" scoped></style>
