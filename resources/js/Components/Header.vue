<script setup>
import ApplicationLogo from "./ApplicationLogo.vue";
</script>
<template>
  <header>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="d-flex align-items-center">
            <ApplicationLogo :width="'75px'" />
            <p><em>La gestione divertente</em></p>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>
<style lang="scss" scoped>
header {
  position: fixed;
  width: 100%;
  top: 0;
  left: 0;
  z-index: 100;
  h2,
  p {
    color: #fff;
  }
}
</style>
