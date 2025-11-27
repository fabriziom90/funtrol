<script setup>
function goBack() {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        window.location.href = "/"; // fallback
    }
}
</script>
<template lang="">
    <button @click="goBack()" class="btn btn-outline-secondary">
        <i class="fa fa-arrow-left me-2"></i> Indietro
    </button>
</template>
<style lang=""></style>
