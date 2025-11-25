<script setup>
import { defineEmits } from "vue";
const props = defineProps({
  show: Boolean,
  type: String,
  message: String,
  classes: String,
  event: Boolean,
});

const emit = defineEmits(["openModal"]);

const openModal = () => {
  emit("openModal");
};
</script>
<template lang="">
  <div class="col-12">
    <div
      :class="`${type}-alert ${classes}`"
      v-on="props.event ? { click: openModal } : {}"
    >
      <i class="fa-solid fa-triangle-exclamation" v-if="type === 'danger'"></i>
      <span class="ms-2">{{ message }}</span>
    </div>
  </div>
</template>
<style lang="scss" scoped>
@use "../styles/_partials/variables" as *;
.danger-alert,
.success-alert {
  cursor: pointer;
}

.danger-alert:hover {
  background-color: $mainRedHover;
}
</style>
