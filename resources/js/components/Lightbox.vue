<template>
    <Transition name="fade">
        <div v-if="isOpen" class="lightFormContainer" @click.self="close">
            <div class="layuotcontainer">
                <div class="mantaContainer">
                    <!-- Header -->
                    <div class="headerContainer">
                        <button
                            @click="close"
                            class="text-3xl leading-none text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            <IconClose />
                        </button>
                    </div>

                    <!-- Contenido del Lightbox -->
                    <div class="bodyContainer">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script setup>
import { ref, defineExpose } from "vue";
import IconClose from "@/assets/icons/close.svg";
const isOpen = ref(false);
const title = ref("");
const imagenCover = ref(""); // ← Nueva variable
const open = (customTitle = "", customImg = "") => {
    title.value = customTitle;
    imagenCover.value = customImg;
    isOpen.value = true;
    document.body.style.overflow = "hidden";
};

const close = () => {
    isOpen.value = false;
    document.body.style.overflow = "visible";
};

// Exponemos las funciones para poder llamarlas desde fuera
defineExpose({
    open,
    close,
});
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
