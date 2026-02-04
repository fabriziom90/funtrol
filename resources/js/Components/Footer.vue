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
              <Link :href="route('production.index')" title="Produzione">
                <i class="fas fa-utensils"></i>
                <span class="no-mobile">Produzione</span>
              </Link>
            </li>
            <li :class="isRouteActive('/warehouse') ? 'active' : ''">
              <Link :href="route('warehouse.index')" title="Magazzino">
                <i class="fa-solid fa-warehouse"></i>
                <span class="no-mobile">Magazzino</span>
              </Link>
            </li>
            <li :class="isRouteActive('/calendar') ? 'active' : ''">
              <Link :href="route('calendar.index')" title="Calendario">
                <i class="fa-solid fa-calendar-days"></i>
                <span class="no-mobile">Calendario</span>
              </Link>
            </li>
            <li :class="isRouteActive('/admin') ? 'active' : ''">
              <Link :href="route('admin.administration.index')" title="Amministrazione">
                <i class="fas fa-gear"></i>
                <span class="no-mobile">Amministrazione</span>
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
    padding: 20px 8px;
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
      display: none;
      padding-top: 10px;
    }
  }
}

@media screen and (min-width: 768px) {
  footer {
    li {
      padding: 20px;
      span {
        display: block;
      }

      a {
        i {
          font-size: 2.5rem;
        }
      }
    }
  }
}
</style>
