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
import { useHead } from '@vueuse/head'
import IngresosPrincipal from '../components/home/Ingresos.vue'
import BannerPrincipal from '../components/Banner.vue'
import ElegirnosPrincipal from '../components/home/Elegirnos.vue'
import PreguntasPrincipal from '../components/home/Preguntas.vue'
import CompraPrincipal from '../components/home/Compra.vue'

// ==================== SEO - useHead ====================
useHead({
    title: 'Acover - Soluciones en Logística y Almacenaje',
    meta: [
        {
            name: 'description',
            content: 'Lockers, material de embalaje y soluciones logísticas de alta calidad en Perú.'
        },
        {
            name: 'keywords',
            content: 'lockers, material de embalaje, almacenamiento industrial, acover, perú'
        }
    ],
    link: [
        { rel: 'canonical', href: 'https://acover.com.pe/' }
    ]
})

// Recibimos los productos destacados desde el controlador
const props = defineProps({
    featuredProducts: {
        type: Array,
        default: () => []
    }
})


</script>