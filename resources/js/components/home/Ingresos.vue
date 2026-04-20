<template>
    <div class="nuevosIngresosHomeSeccion">
        <div class="containerFluid">
            <div class="headerIngresosContainer">
                <div>
                    <h3>PRODUCTOS EN STOCK</h3>
                    <h2>NUEVOS INGRESOS</h2>
                    <p>
                        Innovación, resistencia y eficiencia en cada producto. Descubre las <br />
                        últimas soluciones de ACOVER para optimizar tu operación y <br />
                        fortalecer tu logística.
                    </p>
                    <a href="/lockers" class="btnRelleno">Ver Catálogo</a>
                </div>
            </div>
            <!-- <pre>{{ JSON.stringify(featuredProducts, null, 2) }} </pre> -->
            <div class="bodyIngresosContainer">
                <Splide v-if="featuredProducts && featuredProducts.length > 0" 
                        :options="options" 
                        class="splide-custom">
                    <SplideSlide v-for="product in featuredProducts" :key="product.id">
                        <div class="cardProducts">
                            <div class="imgContainer">
                                <img :src="`/storage/${product.cover_image}`" :alt="product.titulo" />
                            </div>
                            <div class="dataContainer">
                                <h3>{{ product.category?.titulo || 'Categoría' }}</h3>
                                <h2>{{ product.titulo }}</h2>
                                <Link :href="`/producto/${product.category?.slug}/${product.slug}`" class="btnRelleno">
                                    Ver detalles
                                </Link>
                            </div>
                        </div>
                    </SplideSlide>
                </Splide>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { Splide, SplideSlide } from '@splidejs/vue-splide'
import '@splidejs/vue-splide/css'


defineProps({
    featuredProducts: {
        type: Array,
        default: () => []
    }
})

const options = {
    // type: 'loop',
    perPage: 4,
    autoplay: true,
    interval: 5000,
    pauseOnHover: true,
    arrows: true,
    pagination: false,
    gap: '20px',
    breakpoints: {
        992: {              // Cuando la pantalla sea ≤ 992px
        perPage: 1,       // Muestra solo 1 elemento (como tenías antes)
        // Opcional: puedes cambiar más cosas aquí si quieres
        // arrows: false,     // por ejemplo ocultar flechas en móvil
        // pagination: true,
        }
    },
    classes: {
        // Flechas
        arrows: 'splide__arrows arrows-producto-home',
        arrow: 'splide__arrow arrow-producto-home',
        prev: 'splide__arrow--prev arrow-producto-home-prev',
        next: 'splide__arrow--next arrow-producto-home-next',

        // Paginación
        pagination: 'splide__pagination pagination-producto-home',
        page: 'splide__pagination__page page-producto-home',
    }
}

</script>

<style>
/* Ahora usas Tailwind directamente */
.splide__arrow.arrow-producto-home {
    width: 70px;
    height: 70px;
    background: transparent;
    border: 1px solid #084DA6;
    transform: translateY(-50%);
    top: 50%;
    
}

.splide__arrow.arrow-producto-home svg {
    /* width: 33px;
    height: 66px;
    fill: white; */
    display: none;
}

/* Agregamos tu propio SVG como fondo */
.splide__arrow.arrow-producto-home::before {
    content: '';
    display: block;
    width: 16px;
    height: 49px;
    fill: #084DA6;
    color: #084DA6;
    background: currentColor;           /* toma el color del texto */
    mask-image: url('/images/arrow-left.svg');   /* ← tu SVG */
    mask-size: contain;
    mask-repeat: no-repeat;
    mask-position: center;
    -webkit-mask-image: url('/images/arrow-left.svg');
}

.splide__arrow.arrow-producto-home:disabled{
    opacity: 1;
    border: 1px solid #ABABAB;
} 

.splide__arrow.arrow-producto-home:disabled::before{
    fill: #ABABAB;
    color: #ABABAB;
}



.splide__arrow--next.arrow-producto-home-next::before {
  mask-image: url('/images/arrow-right.svg');
  -webkit-mask-image: url('/images/arrow-right.svg');
}

.splide__arrow--prev.arrow-producto-home-prev {
    left: 1rem;
    right: auto;
}

.splide__pagination__page.page-producto-home {
    width: 18px;
    height: 18px;
    background: transparent;
    position: relative;
    border: 1px solid white;
}

.splide__pagination__page.page-producto-home:before{
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

.splide__pagination__page.page-producto-home.is-active {
    background: red;

}

@media screen and (min-width: 992px){
    .splide__arrow.arrow-producto-home {
        width: 80px;
        height: 80px;
        transform: none;
        top: -7.5rem;
    }
    .splide__arrow.arrow-producto-home::before {
        width: 22px;
        height: 55px;
    }
    .splide__arrow--prev.arrow-producto-home-prev {
        /* right: 7rem; */
        left: auto;
        right: 7rem;
    }
}

@media screen and (min-width: 1400px){
    
    .splide__arrow.arrow-producto-home {
        width: 100px;
        height: 100px;
        top: -9rem;
    }
    .splide__arrow.arrow-producto-home::before {
        width: 22px;
        height: 55px;
    }
    .splide__arrow--prev.arrow-producto-home-prev {
        right: 8.5rem;
    }
}
</style>