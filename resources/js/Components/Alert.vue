<script setup>
import { Link } from "@inertiajs/vue3";
import { defineEmits } from "vue";
const props = defineProps({
  show: Boolean,
  type: String,
  message: String,
  classes: String,
  eventAlert: Boolean,
});
</script>
<template>
  <div class="col-12">
    <Link :href="route('warehouse.index')" v-if="eventAlert">
      <div :class="`${type}-alert ${classes}`">
        <i class="fa-solid fa-triangle-exclamation" v-if="type === 'danger'"></i>
        <span class="ms-2">{{ message }}</span>
      </div>
    </Link>
    <div v-else :class="`${type}-alert ${classes}`">
      <i class="fa-solid fa-triangle-exclamation" v-if="type === 'danger'"></i>
      <span class="ms-2">{{ message }}</span>
    </div>
  </div>
</template>
<style lang="scss" scoped>
@use "../../scss/_partials/variables" as *;
.danger-alert,
.success-alert {
  cursor: pointer;
}

.danger-alert:hover {
  background-color: $mainRedHover;
}
</style>
