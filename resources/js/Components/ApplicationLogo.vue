<script setup lang="ts">
import { computed } from "vue";
import logoUrl from "../../assets/logo.png";

const props = defineProps({
  width: String,
  color: String,
  fontSize: String,
  classes: String,
});

const logoStyle = computed(() => {
  return {
    width: props.width || "150px",
  };
});

const titleStyle = computed(() => {
  return {
    color: props.color || "black",
    "font-size": props.fontSize || "35px",
  };
});
</script>

<template>
  <div :class="classes">
    <img :src="logoUrl" :style="logoStyle" alt="FunTrol" />
  </div>
</template>

<style lang="scss" scoped>
h2 {
  font-weight: 600;
  margin-bottom: 0px;
}
</style>
