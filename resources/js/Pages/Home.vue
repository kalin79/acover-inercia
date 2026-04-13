<template>
    <section>
        <BannerPrincipal />
        <ElegirnosPrincipal />
        <IngresosPrincipal />
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


const homeData = ref([]);

onMounted( async () => {
    document.title = 'Acover';
    let description = document.querySelector('meta[name="description"]');
    if (!description) {
        description = document.createElement('meta')
        description.name = 'description'
        document.head.appendChild(description)
    }
    description.content = 'Bienvenido a la tienda más confiable.';

    // try {
    //     homeData.value = await getHome();
    // } catch (error) {
    //     console.error("Error cargando banner:", error);
    // }


})
</script>
