<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>

<template>
  <Head title="Log in" />
  <div class="vh-100 vw-100 d-flex justify-content-center align-items-center">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="d-flex justify-content-center align-items-center">
            <form @submit.prevent="submit" class="form-login">
              <a href="/">
                <ApplicationLogo
                  :classes="'d-flex justify-content-center align-items-center'"
                />
              </a>
              <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
              </div>
              <div class="form-group mt-3">
                <label class="form-label" for="email">Email</label>
                <input
                  class="form-control"
                  v-model="form.email"
                  type="email"
                  id="email"
                  placeholder="Inserisci email"
                  required
                />
              </div>

              <div class="form-group mt-3">
                <label class="form-label" for="password">Password</label>
                <input
                  class="form-control"
                  v-model="form.password"
                  type="password"
                  id="password"
                  placeholder="Inserisci password"
                  required
                />
              </div>

              <div class="form-group mt-3">
                <button class="main-button" :disabled="loading">
                  {{ loading ? "Accesso..." : "Accedi" }}
                </button>
              </div>

              <p v-if="error" class="error">{{ error }}</p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@use "../../../scss/_partials/variables" as *;
.form-login {
  max-width: 450px;
  border: 1px solid $mainGrey;
  padding: 25px;
  border-radius: 10px;
  box-shadow: rgb(174, 174, 174) 0px 0px 25px 10px;
}
</style>
