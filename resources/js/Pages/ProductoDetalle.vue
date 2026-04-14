<template>
    <section class="productoPageContainer">
        <BannerPrincipal />
        <DetallePrincipal 
            :product="product" 
            :category="category"
        />
    </section>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import BannerPrincipal from '../components/productos/Banner.vue';
import DetallePrincipal from '../components/productos/Detalle.vue';
import { usePage } from '@inertiajs/vue3';
const { product, category } = usePage().props;

</script>


