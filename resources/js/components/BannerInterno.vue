<template>
    <div class="bannerInterno">
        <!-- {{ banners.data.banners }} -->
        <Splide v-if="banners" :options="options" class="splide-custom">
            <SplideSlide v-for="(img, index) in banners" :key="index">
                <div class="slideContainer">
                    <img :src="img.poster" alt="Slide" class="imgBanner" />
                </div>
            </SplideSlide>
        </Splide>
    </div>
</template>

<script setup>
import { defineProps } from 'vue'
import { Splide, SplideSlide } from '@splidejs/vue-splide'
import '@splidejs/vue-splide/css'

const options = {
    //   type: 'loop',
    perPage: 1,
    autoplay: true,
    interval: 5000,
    pauseOnHover: true,
    arrows: false,
    pagination: true,
    classes: {
        // Flechas
        arrows: 'splide__arrows my-arrows-home',
        arrow: 'splide__arrow my-arrow-home',
        prev: 'splide__arrow--prev my-arrow-home-prev',
        next: 'splide__arrow--next my-arrow-home-next',

        // Paginación
        pagination: 'splide__pagination my-pagination-home',
        page: 'splide__pagination__page my-page-home',
    }
}

const props = defineProps({
    banners: {
        type: Array,
        required: true,
        default: () => []   // opcional
    }
})
</script>


<style>
/* Ahora usas Tailwind directamente */
.splide__arrows.my-arrow-home {
    width: 70px;
    height: 70px;
    background: transparent;
    border: 1px solid white;
}

.splide__arrow.my-arrow-home svg {
    /* width: 33px;
    height: 66px;
    fill: white; */
    display: none;
}

/* Agregamos tu propio SVG como fondo */
.splide__arrow.my-arrow-home::before {
    content: '';
    display: block;
    width: 16px;
    height: 49px;
    fill: white;
    color: white;
    background: currentColor;           /* toma el color del texto */
    mask-image: url('/images/arrow-left.svg');   /* ← tu SVG */
    mask-size: contain;
    mask-repeat: no-repeat;
    mask-position: center;
    -webkit-mask-image: url('/images/arrow-left.svg');
}

.splide__arrow--next.my-arrow-home-next::before {
  mask-image: url('/images/arrow-right.svg');
  -webkit-mask-image: url('/images/arrow-right.svg');
}

.splide__pagination__page.my-page-home {
    width: 18px;
    height: 18px;
    background: transparent;
    position: relative;
    border: 1px solid white;
}

.splide__pagination__page.my-page-home:before{
    content: '';
    position: absolute;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #fff;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
}

.splide__pagination__page.my-page-home.is-active {
    background: transparent;
}

@media screen and (min-width: 992px){
    .splide__arrow.my-arrow-home {
        width: 90px;
        height: 90px;
    }
    .splide__arrow.my-arrow-home::before {
        width: 22px;
        height: 55px;
    }
}

@media screen and (min-width: 1400px){
    .splide__pagination__page.my-arrow-home {
        width: 114px;
        height: 114px;
    }
    .splide__arrow.my-arrow-home::before {
        width: 33px;
        height: 66px;
    }
}
</style>
