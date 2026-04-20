<template>
    <section class="productoPageContainer">
        <!-- {{ JSON.stringify(product, null, 2) }} -->
        <BannerPrincipal :product="product" />
        <DetallePrincipal :product="product" :category="category" />
    </section>
</template>

<script setup>
import { useHead } from "@vueuse/head";

import { onMounted, ref } from "vue";
import BannerPrincipal from "../components/productos/Banner.vue";
import DetallePrincipal from "../components/productos/Detalle.vue";
import { usePage } from "@inertiajs/vue3";
const { product, category } = usePage().props;
// ==================== SEO - useHead ====================
useHead({
    title: () => {
        // Prioridad: Título del producto > Título de categoría > Título genérico
        if (product?.titulo) {
            return `${product.titulo} | Acover Perú`;
        }
        // if (category?.titulo) {
        //     return `${category.titulo} | Acover Perú`;
        // }
        return "Acover - Soluciones en Logística y Almacenaje";
    },
    meta: [
        // {
        //     name: "description",
        //     content: () => {
        //         if (product?.descripcion && product.descripcion.length > 10) {
        //             return product.descripcion.substring(0, 160) + "...";
        //         }
        //         if (product?.titulo) {
        //             return `Compra ${product.titulo} de alta calidad. Soluciones en logística y almacenamiento industrial en Perú.`;
        //         }
        //         return "Lockers, material de embalaje y soluciones logísticas de alta calidad en Perú.";
        //     },
        // },
        {
            name: "keywords",
            content: () => {
                const base =
                    "lockers, material de embalaje, almacenamiento industrial, acover, perú";
                if (product?.titulo) {
                    return `${product.titulo.toLowerCase()}, ${base}`;
                }
                return base;
            },
        },
        {
            name: "robots",
            content: "index, follow",
        },
    ],

    link: [
        {
            rel: "canonical",
            href: () =>
                `https://acover.com.pe/producto/${category?.slug}/${product?.slug}`,
        },
    ],
});
</script>
