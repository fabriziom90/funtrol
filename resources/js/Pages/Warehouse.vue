<script setup>
import { ref, computed } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import ModalEmailSupplier from "@/Components/ModalEmailSupplier.vue";
import ModalUpdateQuantity from "@/Components/ModalUpdateQuantity.vue";

const props = defineProps({
  products: Array,
  authUser: Object,
});

const search = ref("");
const selectedProduct = ref(null);
const modalUpdateQuantityOpen = ref(false);
const modalEmailSupplierOpen = ref(false);

const filteredProducts = ref(props.products);

const filterProducts = computed(() => {
  if (search !== "") {
    return props.products.filter((product) =>
      product.name.toLowerCase().includes(search.value.toLowerCase())
    );
  }

  return filteredProducts;
});

const openModalOrder = (product) => {
  selectedProduct.value = product;
  modalEmailSupplierOpen.value = true;
};

const openModalUpdate = (product) => {
  selectedProduct.value = product;
  modalUpdateQuantityOpen.value = true;
};

const closeModal = () => {
  selectedProduct.value = null;
  modalEmailSupplierOpen.value = false;
  modalUpdateQuantityOpen.value = false;
};
</script>
<template>
  <Head title="Magazzino" />
  <MainLayout>
    <div class="row gy-3">
      <div class="col-12">
        <h2><i class="fas fa-warehouse fa-xl"></i> Magazzino (Riepilogo)</h2>
        <p class="pt-3">Visualizzazione solo consultiva.</p>
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
          <div class="d-flex justify-content-between align-items-center p-4">
            <div class="d-flex align-items-center">
              <div>
                <h4 class="d-flex align-items-center">
                  <span
                    class="dot"
                    :class="`dot-${
                      product.grams_in_warehouse > product.min_stock ? 'green' : 'red'
                    }`"
                  ></span>
                  <span>{{ product.name }}</span>
                </h4>
              </div>
              <div class="mx-4 mt-2">
                <strong>Fornitore:</strong>
                {{ product.supplier.name }}
              </div>
              <div class="mt-2"><strong>Prezzo:</strong> {{ product.price }} €</div>
            </div>
            <div class="d-flex justify-content-center align-items-center">
              <div class="me-3">
                <h4>
                  {{ product.grams_in_warehouse }}
                  {{ product.unit }}
                </h4>
                <p>
                  Soglia: {{ product.min_stock }}
                  {{ product.unit }}
                </p>
              </div>
              <div class="d-flex flex-column">
                <button class="btn btn-primary mb-2" @click="openModalOrder(product)">
                  <i class="fa-solid fa-envelope"></i>
                  Contatta fornitore
                </button>
                <button class="btn btn-warning" @click="openModalUpdate(product)">
                  <i class="fa-solid fa-edit"></i>
                  Aggiorna quantità
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <ModalEmailSupplier
      v-if="modalEmailSupplierOpen"
      :product="selectedProduct"
      :allProducts="props.products"
      :authUser="props.authUser"
      @close="closeModal"
    />
    <ModalUpdateQuantity
      v-if="modalUpdateQuantityOpen"
      :product="selectedProduct"
      @close="closeModal"
      @update="filteredProducts = props.products"
    />
  </MainLayout>
</template>
<style lang="scss" scoped>
@use "../../scss/_partials/variables" as *;

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
