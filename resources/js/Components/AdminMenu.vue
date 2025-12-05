<script setup>
import { Link, usePage } from "@inertiajs/vue3";
const page = usePage();

const isRouteActive = (route) => {
  console.log(page.url, route);
  return page.url.includes(route);
};
</script>
<template>
  <div class="mt-4" id="sections">
    <Link
      :href="route('admin.products.index')"
      :class="isRouteActive('/products') ? 'active' : ''"
      class="link-section"
    >
      Gestione Prodotti
    </Link>
    <Link
      :href="route('admin.recepies.index')"
      class="link-section"
      :class="isRouteActive('/recepies') ? 'active' : ''"
    >
      Gestione Ricette
    </Link>
    <Link
      :href="route('admin.suppliers.index')"
      :class="isRouteActive('/suppliers') ? 'active' : ''"
      class="link-section"
    >
      Gestione Fornitori
    </Link>
    <Link class="link-section"> Storico Prezzi </Link>
  </div>
</template>
<style lang="scss" scoped>
@use "../../scss/app.scss";
@use "../../scss/_partials/variables" as *;

#sections {
  margin-bottom: 40px;
  .link-section {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    background-color: #e5e7eb;
    margin: 0px 10px 0px 0px;
    padding: 15px 10px;
    cursor: pointer;
    transition: 0.3s;

    &.active {
      background-color: $mainBlue;
      color: #fff;
    }

    &:hover {
      background-color: $mainBlue;
      color: #fff;
    }
  }
}
</style>
