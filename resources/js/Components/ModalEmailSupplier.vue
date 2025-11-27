<script setup>
import { ref, defineEmits } from "vue";

defineProps({
    showModal: Boolean,
});

const emit = defineEmits(["close"]);

const isLoading = ref(false);

const email = ref(
    "Gentile Fornitore,\nSi richiede il riordino urgente dei seguenti prodotti:\n- Mozzarella (quantità da definire)\n- Farina Integrale (quantità da definire)\n- Mozzarella (quantità da definire)\n- Cioccolato (quantità da definire)\nCordiali Saluti,\nFunTrol Operatore"
);

const handleSubmit = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        emit("close");
    }, 1500);
};
</script>
<template lang="">
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <h2>
                            <i
                                class="fa-solid fa-triangle-exclamation fa-2xl me-2"
                            ></i
                            >Avviso Scorte sotto soglia
                        </h2>
                    </div>
                    <div class="modal-body">
                        La produzione giornaliera ha portato i seguenti 3
                        prodotti sotto la soglia minima di riordino:
                        <div class="alert alert-danger mt-2">
                            <ul class="list-unstyled m-0">
                                <li
                                    class="d-flex justify-content-between align-items-center"
                                >
                                    <span>Mozzarella</span
                                    ><strong>11.95kg</strong>
                                </li>
                                <li
                                    class="d-flex justify-content-between align-items-center"
                                >
                                    <span>Farina Integrale</span
                                    ><strong>80kg</strong>
                                </li>
                                <li
                                    class="d-flex justify-content-between align-items-center"
                                >
                                    <span>Cioccolato</span><strong>5kg</strong>
                                </li>
                            </ul>
                        </div>
                        <div class="textarea-container">
                            <textarea
                                name=""
                                id=""
                                class="form-control"
                                v-model="email"
                                rows="10"
                            ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            class="secondary-button me-2"
                            @click="$emit('close')"
                        >
                            Annulla
                        </button>
                        <button class="main-button" @click="handleSubmit">
                            <span v-if="!isLoading"
                                ><i class="fa-regular fa-paper-plane"></i>Invia
                                Ordine
                            </span>
                            <span v-else>
                                <i class="fa-solid fa-circle-notch fa-spin"></i
                                >Invio...</span
                            >
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
<style lang="scss" scoped>
@use "../../scss/app.scss";
@use "../../scss/_partials/variables" as *;
.modal-header {
    color: $mainRed;

    h2 {
        font-size: 20px;
    }
}

.list-unstyled strong {
    color: $mainRed;
}

.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: table;
    transition: opacity 0.3s ease;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}

.modal-container {
    width: 750px;
    max-width: 600px;
    margin: 0px auto;
    padding: 45px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
    transition: all 0.3s ease;
    border-radius: 25px;
}

.modal-header h3 {
    margin-top: 0;
    color: #42b983;
}

.modal-body {
    margin: 20px 0;
}

.modal-default-button {
    float: right;
}

.modal-enter {
    opacity: 0;
}

.modal-leave-active {
    opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
}
</style>
