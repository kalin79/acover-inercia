import { ref, inject } from "vue";

export function useLightbox() {
    // Intentamos obtener el lightboxRef desde el Layout (usando provide/inject)
    const lightboxRef = inject("lightboxRef", ref(null));

    const openLightbox = (title = "Cotiza con Acover") => {
        if (lightboxRef.value) {
            lightboxRef.value.open(title);
        } else {
            console.warn(
                "⚠️ Lightbox no encontrado. Asegúrate de que esté en FrontLayout.vue",
            );
        }
    };

    const closeLightbox = () => {
        if (lightboxRef.value) {
            lightboxRef.value.close();
        }
    };

    return {
        openLightbox,
        closeLightbox,
    };
}
