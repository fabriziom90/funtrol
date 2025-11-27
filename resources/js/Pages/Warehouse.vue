<script setup>
import { ref, computed } from "vue";
const search = ref("");
const products = [
    {
        id: 1,
        name: "Farina 00",
        threshold: 50,
        unit: "Kg",
        available: 250,
    },
    {
        id: 2,
        name: "Mozzarella",
        threshold: 20,
        unit: "Kg",
        available: 12,
    },
    {
        id: 3,
        name: "Farina Integrale",
        threshold: 80,
        unit: "Kg",
        available: 50,
    },
    {
        id: 4,
        name: "Lievito",
        threshold: 5,
        unit: "Kg",
        available: 10,
    },
    {
        id: 5,
        name: "Burro",
        threshold: 45,
        unit: "Kg",
        available: 50,
    },
    {
        id: 6,
        name: "Cioccolato",
        threshold: 15,
        unit: "Kg",
        available: 5,
    },
];
const filteredProducts = ref(products);

const filterProducts = computed(() => {
    if (search !== "") {
        return products.filter((product) =>
            product.name.toLowerCase().includes(search.value.toLowerCase())
        );
    }

    return filteredProducts;
});
</script>
<template lang="">
    <div class="row gy-3">
        <div class="col-12">
            <h2>
                <i class="fas fa-warehouse fa-xl"></i>
                Magazzino (Riepilogo)
            </h2>
            <p class="pt-3">
                Visualizzazione solo consultiva. Aggiornamento in tempo reale.
            </p>
        </div>
        <div class="col-12">
            <div class="input-wrapper">
                <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                <input
                    type="text"
                    placeholder="Cerca..."
                    v-model="search"
                    class="form-control form-control-lg"
                />
            </div>
        </div>
        <div class="col-12" v-for="product in filterProducts" :key="product.id">
            <div class="card">
                <div
                    class="d-flex justify-content-between align-items-center p-4"
                >
                    <div>
                        <h4 class="d-flex align-items-center">
                            <span
                                class="dot"
                                :class="`dot-${
                                    product.available > product.threshold
                                        ? 'green'
                                        : 'red'
                                }`"
                            ></span>
                            <span>{{ product.name }}</span>
                        </h4>
                    </div>
                    <div>
                        <h4>{{ product.available }} {{ product.unit }}</h4>
                        <p>
                            Soglia: {{ product.threshold }} {{ product.unit }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style lang="scss" scoped>
@use "../../_partials/variables" as *;

h2 {
    color: $mainBlue;
}

.dot {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 10px;
    margin-top: 5px;
}

.dot-green {
    background-color: green;
}

.dot-red {
    background-color: $mainRed;
}

.input-wrapper {
    position: relative;
    display: inline-block;
    width: 100%;
}
.input-wrapper i {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
}
.input-wrapper input {
    padding-left: 50px;
}
</style>
