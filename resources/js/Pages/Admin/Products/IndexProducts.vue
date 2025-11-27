<script setup>
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import GoBackButton from "@/Components/GoBackButton.vue";
import AdminMenu from "@/Components/AdminMenu.vue";

import { ref } from "vue";
const headers = [
    { text: "PLAYER", value: "player" },
    { text: "TEAM", value: "team" },
    { text: "NUMBER", value: "number" },
    { text: "POSITION", value: "position" },
    { text: "HEIGHT", value: "indicator.height" },
    { text: "WEIGHT (lbs)", value: "indicator.weight", sortable: true },
    { text: "LAST ATTENDED", value: "lastAttended", width: 200 },
    { text: "COUNTRY", value: "country" },
];

const items = [
    {
        player: "Stephen Curry",
        team: "GSW",
        number: 30,
        position: "G",
        indicator: { height: "6-2", weight: 185 },
        lastAttended: "Davidson",
        country: "USA",
    },
    {
        player: "Lebron James",
        team: "LAL",
        number: 6,
        position: "F",
        indicator: { height: "6-9", weight: 250 },
        lastAttended: "St. Vincent-St. Mary HS (OH)",
        country: "USA",
    },
    {
        player: "Kevin Durant",
        team: "BKN",
        number: 7,
        position: "F",
        indicator: { height: "6-10", weight: 240 },
        lastAttended: "Texas-Austin",
        country: "USA",
    },
    {
        player: "Giannis Antetokounmpo",
        team: "MIL",
        number: 34,
        position: "F",
        indicator: { height: "6-11", weight: 242 },
        lastAttended: "Filathlitikos",
        country: "Greece",
    },
];
</script>
<template lang="">
    <Head title="Amministrazione Prodotti" />
    <MainLayout>
        <div class="d-flex justify-content-between align-items-center">
            <AdminMenu /> <GoBackButton />
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <h2>Gestione prodotti</h2>
        </div>
        <div><EasyDataTable :headers="headers" :items="items" /></div>
    </MainLayout>
</template>
<style lang="scss" scoped></style>
