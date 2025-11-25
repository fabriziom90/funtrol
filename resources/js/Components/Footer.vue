<script setup></script>
<template lang="">
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <ul class="d-flex justify-content-center align-items-center">
            <li :class="{ active: $route.path === '/' }">
              <router-link to="/">
                <i class="fas fa-utensils fa-2xl"></i>
                <span>Produzione</span>
              </router-link>
            </li>
            <li :class="{ active: $route.path === '/warehouse' }">
              <router-link to="/warehouse">
                <i class="fa-solid fa-warehouse fa-2xl"></i>
                <span>Magazzino</span>
              </router-link>
            </li>
            <li :class="{ active: $route.path === '/calendar' }">
              <router-link to="/calendar">
                <i class="fa-solid fa-calendar-days fa-2xl"></i>
                <span>Calendario</span>
              </router-link>
            </li>
            <li>
              <a href="#">
                <i class="fas fa-gear fa-2xl"></i>
                <span>Amministrazione</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</template>
<style lang="scss" scoped>
@use "../styles/app.scss";
@use "../styles/_partials/variables" as *;

footer {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  border-top: 1px solid #c7c7c7;
  background-color: #fff;
  z-index: 80;
  li {
    padding: 20px;
    text-align: center;

    &.active {
      border-top: 3px solid $mainBlue;

      a {
        color: $mainBlue;
      }
    }

    a {
      color: grey;
    }
    span {
      display: block;
      padding-top: 10px;
    }
  }
}
</style>
