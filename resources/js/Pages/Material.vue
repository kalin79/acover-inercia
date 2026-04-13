<template>
    <section>
        <BannerInterno :banners="banners"/>
        <ListadoProductos />
    </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';

import BannerInterno from '../components/BannerInterno.vue';
import ListadoProductos from '../components/productos/Listado2.vue';
const banners = [
    {
        poster: '/images/nn2.webp',

    }
]
onMounted( async () => {
    document.title = 'Acover :: Tienda Lockers';
    let description = document.querySelector('meta[name="description"]');
    if (!description) {
        description = document.createElement('meta')
        description.name = 'description'
        document.head.appendChild(description)
    }
    description.content = 'Bienvenido a la tienda más confiable.';
})
</script>
