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
          <div class="d-flex justify-content-between p-4">
            <div class="d-flex mobile-column">
              <h4 class="d-flex">
                <span
                  class="dot"
                  :class="`dot-${
                    product.grams_in_warehouse > product.min_stock ? 'green' : 'red'
                  }`"
                ></span>
                <span>{{ product.name }}</span>
              </h4>

              <div class="mt-2">
                <strong>Fornitore:</strong>
                {{ product.supplier.name }}
              </div>
              <div class="mt-2"><strong>Prezzo:</strong> {{ product.price }} €</div>
            </div>
            <div class="d-flex mobile-column mt-2">
              <div class="me-3">
                <h4 class="mobile-column">
                  {{ product.grams_in_warehouse }}
                  {{ product.unit }}
                </h4>
                <p class="mobile-column">
                  Soglia: {{ product.min_stock }}
                  {{ product.unit }}
                </p>
              </div>
              <div class="d-flex row-buttons mt-3">
                <button
                  class="btn btn-primary mb-2 me-2"
                  @click="openModalOrder(product)"
                >
                  <i class="fa-solid fa-envelope"></i>
                  <span class="no-mobile">Contatta fornitore</span>
                </button>
                <a
                  class="btn btn-success mb-2 me-2"
                  :href="`tel:${product.supplier.phone}`"
                >
                  <i class="fas fa-phone"></i>
                  <span class="no-mobile">Chiama fornitore</span>
                </a>
                <button
                  class="btn btn-warning mb-2 me-2"
                  @click="openModalUpdate(product)"
                >
                  <i class="fa-solid fa-edit"></i>
                  <span class="no-mobile">Aggiorna quantità</span>
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

.card > div {
  flex-direction: column;
  align-items: stretch;
}

.mobile-column {
  width: 100%;
  align-items: flex-start;
  flex-direction: column;
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

.no-mobile {
  display: none;
}

.row-buttons {
  flex-direction: row;
}

@media screen and (min-width: 768px) {
  .no-mobile {
    display: inline-block;
    margin-left: 10px;
  }

  .card > div {
    flex-direction: row;
  }

  .mobile-column {
    flex-direction: row;
    align-items: center;
  }

  .mobile-column h4,
  .mobile-column div {
    margin-right: 10px;
  }

  .mobile-column:last-child {
    justify-content: flex-end;
  }

  .row-buttons {
    flex-direction: column;
  }
}
</style>
