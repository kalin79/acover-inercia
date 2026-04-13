<template>
    <section>
        <BannerInterno :banners="banners" />
        <ListadoProductos />
    </section>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue';

import BannerInterno from '../components/BannerInterno.vue';
import ListadoProductos from '../components/productos/Listado.vue';

const page = usePage()


const banners = [
    {
        poster: '/images/bb1.webp',

    }
]
// Ejemplo: leer título y descripción que envías desde Laravel
console.log(page.props.title)
console.log(page.props.description)

// O actualizar el título dinámicamente
onMounted(() => {
    document.title = page.props.title || 'Acover'
})
</script>
