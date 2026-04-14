<template>
    <section>
        <BannerInterno :category="category" />
        <ListadoProductos 
            :products="products" 
            :category="category"
        />
    </section>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue';

import BannerInterno from '../components/BannerInterno.vue';
import ListadoProductos from '../components/productos/Listado.vue';

const { products, category } = usePage().props;


const banners = [
    {
        poster: '/images/bb1.webp',

    }
]

// O actualizar el título dinámicamente
onMounted(() => {
    // document.title = page.props.title || 'Acover'
})
</script>
