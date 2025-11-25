<script setup>
import Header from "../Components/Header.vue";
import Footer from "../Components/Footer.vue";
</script>
<template>
    <Header />
    <main class="px-3">
        <div class="container-fluid">
            <router-view />
        </div>
    </main>
    <Footer />
</template>
<style lang="scss" scoped>
main {
    margin: 150px 0px;
}
</style>
