<script setup>
import { Link, usePage } from "@inertiajs/vue3";
const page = usePage();

const isRouteActive = (route) => {
  return page.url.includes(route);
};
</script>
<template>
  <ul class="mt-4" id="sections">
    <li>
      <Link
        v-if="page.props.auth.user.role === 'superadmin'"
        :href="route('admin.stores.index')"
        :class="isRouteActive('/stores') ? 'active' : ''"
        class="link-section"
      >
        Gestione Negozi
      </Link>
    </li>
    <li>
      <Link
        :href="route('products.index')"
        :class="isRouteActive('/products') ? 'active' : ''"
        class="link-section"
      >
        Gestione Prodotti
      </Link>
    </li>
    <li>
      <Link
        :href="route('recepies.index')"
        class="link-section"
        :class="isRouteActive('/recepies') ? 'active' : ''"
      >
        Gestione Ricette
      </Link>
    </li>
    <li>
      <Link
        :href="route('suppliers.index')"
        :class="isRouteActive('/suppliers') ? 'active' : ''"
        class="link-section"
      >
        Gestione Fornitori
      </Link>
    </li>
    <li>
      <Link
        class="link-section"
        :href="route('orders.index')"
        :class="isRouteActive('/orders') ? 'active' : ''"
      >
        Storico Ordini</Link
      >
    </li>
  </ul>
</template>
<style lang="scss" scoped>
@use "../../scss/app.scss";
@use "../../scss/_partials/variables" as *;

#sections {
  margin-bottom: 40px;
  display: flex;
  flex-wrap: wrap;

  li {
    margin-top: 50px;
  }

  .link-section {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    background-color: #e5e7eb;
    margin: 0px 10px 0px 0px;
    padding: 15px 10px;
    cursor: pointer;
    transition: 0.3s;
    font-size: 15px;

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
