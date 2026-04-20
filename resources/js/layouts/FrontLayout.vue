<template>
    <div>
        <Header />
        <main>
            <slot />
        </main>
        <Footer />
        <CookieBanner />
        <WhatsAppContainer />

        <!-- Lightbox Global -->
        <Lightbox ref="lightboxRef">
            <CotizacionForm
                :title="currentTitle"
                :imagenCover="currentImg"
                @success="closeLightbox"
            />
        </Lightbox>
    </div>
</template>

<script setup>
import { ref, provide } from "vue";

import Header from "@/js/components/Header.vue";
import Footer from "@/js/components/Footer.vue";
import CookieBanner from "@/js/components/CookieConsent.vue";
import WhatsAppContainer from "@/js/components/Whatsapp.vue";

import Lightbox from "@/js/Components/Lightbox.vue";
import CotizacionForm from "@/js/Components/CotizacionForm.vue";

// Referencia al componente Lightbox
const lightboxRef = ref(null);
const currentTitle = ref("");
const currentImg = ref("");
// Función para abrir el lightbox (disponible en toda la app)
const openCotizacion = (titulo = "", imagenCover = "") => {
    currentTitle.value = titulo;
    currentImg.value = imagenCover;
    lightboxRef.value?.open(titulo);
};

// Función para cerrar el lightbox
const closeLightbox = () => {
    lightboxRef.value?.close();
};

// Proporcionamos la función openCotizacion a todas las páginas
provide("openCotizacion", openCotizacion);
</script>
