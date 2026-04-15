<template>
    <section>
        <BannerPrincipal />
        <ElegirnosPrincipal />
        <IngresosPrincipal :featuredProducts="featuredProducts" />
        <PreguntasPrincipal />
        <CompraPrincipal />
    </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import IngresosPrincipal from '../components/home/Ingresos.vue';
import BannerPrincipal from '../components/Banner.vue';
import ElegirnosPrincipal from '../components/home/Elegirnos.vue';
import PreguntasPrincipal from '../components/home/Preguntas.vue';
import CompraPrincipal from '../components/home/Compra.vue';
// import { getHome } from "../services/homeService";


defineProps({
    featuredProducts: {
        type: Array,
        default: () => []
    }
})

onMounted( async () => {
     document.title = 'Acover'

    // try {
    //     homeData.value = await getHome();
    // } catch (error) {
    //     console.error("Error cargando banner:", error);
    // }


})
</script>
