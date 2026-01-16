<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const isRouteActive = (route) => {
  return page.url.includes(route);
};
</script>
<template>
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <ul class="d-flex justify-content-center align-items-center">
            <li :class="isRouteActive('/production') ? 'active' : ''">
              <Link :href="route('production.index')">
                <i class="fas fa-utensils"></i>
                <span>Produzione</span>
              </Link>
            </li>
            <li :class="isRouteActive('/warehouse') ? 'active' : ''">
              <Link :href="route('warehouse.index')">
                <i class="fa-solid fa-warehouse"></i>
                <span>Magazzino</span>
              </Link>
            </li>
            <li :class="isRouteActive('/calendar') ? 'active' : ''">
              <Link :href="route('calendar.index')">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Calendario</span>
              </Link>
            </li>
            <li :class="isRouteActive('/admin') ? 'active' : ''">
              <Link :href="route('admin.administration.index')">
                <i class="fas fa-gear"></i>
                <span>Amministrazione</span>
              </Link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</template>
<style lang="scss" scoped>
@use "../../scss/app.scss";
@use "../../scss/_partials/variables" as *;

footer {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  border-top: 1px solid #c7c7c7;
  background-color: #fff;
  z-index: 80;
  ul {
    max-width: 100%;
  }
  li {
    padding: 20px;
    min-width: 60px;
    text-align: center;

    &.active {
      border-top: 3px solid $mainBlue;

      a {
        color: $mainBlue;
      }
    }

    a {
      color: grey;
      i {
        font-size: 2.5rem;
      }
    }
    span {
      display: block;
      padding-top: 10px;
    }
  }
}

// media query per schermi molto piccoli
@media (max-width: 768px) {
  footer {
    li {
      padding: 8px;

      a {
        font-size: 10px;
        i {
          font-size: 1.2rem; // icone più piccole su schermi stretti
        }
      }
    }
  }
}
</style>
