<template>
    <div class="bannerProductoDetail">
        <picture>
            <source
                media="(max-width: 768px)"
                :srcset="`/storage/${product.banner_mobile}`"
            />
            <img
                :src="`/storage/${product.banner_pc}`"
                alt="Slide"
                class="imgBanner"
            />
        </picture>
    </div>
</template>

<script setup>
const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});
const img = "/images/ba1.webp";
</script>
