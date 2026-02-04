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
const showActions = computed(() => props.showView || props.showEdit || props.showDelete);

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
  <div class="data-grid">
    <!-- HEADER (desktop only) -->
    <div class="data-header">
      <div class="data-cell header-cell" v-for="header in headers" :key="header.value">
        {{ header.text }}
      </div>
      <div v-if="showActions" class="data-cell header-cell">Strumenti</div>
    </div>

    <!-- ROWS -->
    <div class="data-row" v-for="item in filteredItems" :key="item.id">
      <div
        class="data-cell"
        v-for="header in headers"
        :key="header.value"
        :data-label="header.text"
      >
        <!-- supplier -->
        <span v-if="header.value === 'supplier'">
          {{ item[header.value].name }}
        </span>

        <!-- products -->
        <div v-else-if="header.value === 'products'" class="products-box">
          <table id="order-products-table" class="table">
            <thead>
              <th>Prodotto</th>
              <th>Prezzo al kg</th>
              <th>Quantità ordinata</th>
              <th>Totale prodotto</th>
            </thead>
            <tbody>
              <tr v-for="product in item[header.value]" :key="product.id">
                <td>{{ product.name }}</td>
                <td>{{ product.price }}€/kg</td>
                <td>{{ product.pivot.quantity }}g</td>
                <td>
                  {{ ((product.pivot.quantity * product.price) / 1000).toFixed(2) }}€
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- default -->
        <span v-else>
          {{ item[header.value] }}
          {{
            header.value === "price" || header.value === "total"
              ? "€"
              : item.unit
              ? item.unit
              : ""
          }}
        </span>
      </div>

      <!-- ACTIONS -->
      <div v-if="showActions" class="data-cell actions-cell">
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
      </div>
    </div>

    <!-- EMPTY -->
    <div v-if="filteredItems.length === 0" class="empty-row">Nessun dato disponibile</div>
  </div>
</template>
<style lang="scss" scoped>
@use "../../scss/app.scss";
@use "../../scss/_partials/variables" as *;
/* =========================
   GRID BASE (mobile first)
   ========================= */

.data-grid {
  width: 100%;
  display: block;
  font-size: 14px;
}

/* HEADER (nascosto su mobile) */
.data-header {
  display: none;
}

/* RIGA */
.data-row {
  display: block;
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 6px;
  margin-bottom: 12px;
  padding: 12px;
}

/* CELLE */
.data-cell {
  display: flex;
  justify-content: space-between;
  gap: 12px;
  padding: 6px 0;
  border-bottom: 1px dashed #e0e0e0;
}

.data-cell:last-child {
  border-bottom: none;
}

/* label mobile */
.data-cell::before {
  content: attr(data-label);
  font-weight: 600;
  color: #555;
  flex: 0 0 45%;
}

/* contenuto */
.data-cell > span,
.data-cell > div {
  flex: 1;
  text-align: right;
  word-break: break-word;
}

/* AZIONI */
.actions-cell {
  justify-content: flex-end;
  gap: 6px;
}

.actions-cell::before {
  display: none;
}

/* =========================
   PRODUCTS SUBTABLE (mobile)
   ========================= */

.products-box {
  width: 100%;
  margin-top: 8px;
}

#order-products-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}

#order-products-table thead {
  display: none;
}

#order-products-table tr {
  display: block;
  border: 1px solid #ddd;
  border-radius: 6px;
  padding: 8px;
  margin-bottom: 8px;
  background: #fafafa;
}

#order-products-table td {
  display: flex;
  justify-content: space-between;
  padding: 4px 0;
}

#order-products-table td::before {
  font-weight: 600;
  color: #555;
}

#order-products-table td:nth-child(1)::before {
  content: "Prodotto";
}
#order-products-table td:nth-child(2)::before {
  content: "Prezzo";
}
#order-products-table td:nth-child(3)::before {
  content: "Quantità";
}
#order-products-table td:nth-child(4)::before {
  content: "Totale";
}

/* =========================
   EMPTY
   ========================= */

.empty-row {
  text-align: center;
  padding: 20px;
  color: #777;
}

/* =========================
   DESKTOP ≥ 768px
   ========================= */

@media (min-width: 768px) {
  .data-grid {
    display: block;
  }

  /* HEADER */
  .data-header {
    display: grid;
    grid-template-columns:
      80px /* ID */
      minmax(180px, 2fr) /* Nome */
      minmax(200px, 2fr) /* Fornitore */
      minmax(120px, 1fr) /* Prezzo */
      minmax(300px, 3fr) /* Prodotti */
      auto; /* Azioni */
    background: #f3f3f3;
    border: 1px solid #ddd;
    border-radius: 6px 6px 0 0;
  }

  .header-cell {
    padding: 10px;
    font-weight: 600;
    border-right: 1px solid #ddd;
  }

  .header-cell:last-child {
    border-right: none;
  }

  /* ROW */
  .data-row {
    display: grid;
    grid-template-columns:
      80px
      minmax(180px, 2fr)
      minmax(200px, 2fr)
      minmax(120px, 1fr)
      minmax(300px, 3fr)
      auto;
    align-items: start;
    border-top: none;
    border-radius: 0 0 6px 6px;
    padding: 0;
  }

  .data-row:not(:last-child) {
    border-bottom: 1px solid #ddd;
  }

  /* CELLE */
  .data-cell {
    display: block;
    padding: 10px;
    border-bottom: none;
    border-right: 1px solid #eee;
  }

  .data-cell::before {
    display: none;
  }

  .data-cell > span,
  .data-cell > div {
    text-align: left;
  }

  .actions-cell {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    border-right: none;
  }

  /* =========================
     PRODUCTS SUBTABLE DESKTOP
     ========================= */

  #order-products-table {
    font-size: 13px;
    border: 1px solid #ddd;
    border-radius: 6px;
    overflow: hidden;
  }

  #order-products-table thead {
    display: table-header-group;
    background: #f7f7f7;
  }

  #order-products-table th,
  #order-products-table td {
    padding: 6px 8px;
    border-bottom: 1px solid #eee;
    text-align: left;
  }

  #order-products-table tr {
    display: table-row;
    background: white;
    border: none;
    padding: 0;
    margin: 0;
  }

  #order-products-table td::before {
    display: none;
  }

  #order-products-table td {
    display: table-cell;

    padding: 4px 5px;
  }
}
</style>
