<script setup>
import { ref, computed, watch } from "vue";

// --- 1️⃣ Props correttamente definite all’inizio ---
const props = defineProps({
    headers: { type: Array, required: true }, // {text, value, filterable}
    items: { type: Array, required: true },
    showView: { type: Boolean, default: true },
    showEdit: { type: Boolean, default: true },
    showDelete: { type: Boolean, default: true },
});

// --- 2️⃣ Variabili locali ---
const showActions = computed(
    () => props.showView || props.showEdit || props.showDelete
);

// Filtri
const filters = ref({});
props.headers.forEach((h) => {
    if (h.filterable) filters.value[h.value] = "";
});

// --- 3️⃣ Computed filtraggio ---
const filteredItems = computed(() => {
    if (!props.items) return [];
    return props.items.filter((item) => {
        return props.headers.every((header) => {
            if (!header.filterable) return true;
            const filter = (filters.value[header.value] || "").toLowerCase();
            const value = (item[header.value] ?? "").toString().toLowerCase();
            return value.includes(filter);
        });
    });
});
</script>
<template>
    <div>
        <!-- Filtri per colonna -->
        <div class="row g-2 mb-2" v-if="headers.some((h) => h.filterable)">
            <div class="col" v-for="header in headers" :key="header.value">
                <input
                    v-if="header.filterable"
                    type="text"
                    class="form-control form-control-sm"
                    :placeholder="'Filtra ' + header.text"
                    v-model="filters[header.value]"
                />
            </div>
        </div>

        <!-- Tabella -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th v-for="header in headers" :key="header.value">
                        {{ header.text }}
                    </th>
                    <th v-if="showActions">Strumenti</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in filteredItems" :key="item.id">
                    <td v-for="header in headers" :key="header.value">
                        {{ item[header.value] }}
                    </td>
                    <td v-if="showActions">
                        <button
                            v-if="showView"
                            class="btn btn-sm btn-info me-1"
                            @click="$emit('view', item)"
                        >
                            <i class="fa fa-eye"></i>
                        </button>
                        <button
                            v-if="showEdit"
                            class="btn btn-sm btn-warning me-1"
                            @click="$emit('edit', item)"
                        >
                            <i class="fa fa-edit"></i>
                        </button>
                        <button
                            v-if="showDelete"
                            class="btn btn-sm btn-danger"
                            @click="$emit('delete', item)"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <tr v-if="filteredItems.length === 0">
                    <td
                        :colspan="headers.length + (showActions ? 1 : 0)"
                        class="text-center"
                    >
                        Nessun dato disponibile
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<style lang="scss" scoped>
@use "../../scss/app.scss";
@use "../../scss/_partials/variables" as *;
thead {
    th {
        background-color: $mainBlue;
        color: #fff;
    }
}
</style>
