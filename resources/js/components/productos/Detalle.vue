<template>
    <div class="productoDetalleSeccion">
        <div class="containerFluid">
            <!-- {{ JSON.stringify(product, null, 2) }} -->
            <div class="layoutGrid">
                <div class="productoImagenesContainer">
                    <!-- Imagen principal con Splide -->
                    <Splide
                        ref="mainSplide"
                        :options="mainOptions"
                        class="main-slider"
                    >
                        <SplideSlide
                            v-for="(image, index) in product.media"
                            :key="index"
                        >
                            <div
                                class="productoViewContainer"
                                v-if="image.type === 'image'"
                            >
                                <img
                                    :src="`/storage/${image.file_path}`"
                                    class="main-image"
                                />
                            </div>
                            <div
                                class="productoViewContainer negro"
                                v-if="image.type === 'video'"
                            >
                                <video controls>
                                    <source
                                        :src="`/storage/${image.file_path}`"
                                        type="video/mp4"
                                    />
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div
                                class="productoViewContainer negro"
                                v-if="image.type === 'youtube'"
                            >
                                <iframe
                                    :src="getYoutubeEmbedUrl(image.youtube_url)"
                                    width="100%"
                                    height="100%"
                                    title="YouTube video"
                                    frameborder="0"
                                    allow="
                                        accelerometer;
                                        autoplay;
                                        clipboard-write;
                                        encrypted-media;
                                        gyroscope;
                                        picture-in-picture;
                                    "
                                    allowfullscreen
                                ></iframe>
                            </div>
                        </SplideSlide>
                    </Splide>

                    <!-- Miniaturas -->
                    <Splide
                        :options="thumbnailOptions"
                        class="thumbnail-slider"
                        ref="thumbnailSplide"
                    >
                        <SplideSlide
                            v-for="(image, index) in product.media"
                            :key="index"
                            @click="goToSlide(index)"
                        >
                            <img
                                v-if="image.type === 'image'"
                                :src="`/storage/${image.file_path}`"
                                class="thumbnail"
                            />
                            <div
                                v-else-if="image.type === 'video'"
                                class="thumbnail-video"
                            >
                                <video
                                    :src="`/storage/${image.file_path}`"
                                    muted
                                ></video>
                                <div class="play-overlay">▶</div>
                            </div>
                            <div
                                v-else-if="image.type === 'youtube'"
                                class="thumbnail-youtube"
                            >
                                <img
                                    :src="
                                        getYoutubeThumbnail(image.youtube_url)
                                    "
                                    alt="YouTube"
                                />
                                <div class="play-overlay">▶</div>
                            </div>
                        </SplideSlide>
                    </Splide>
                </div>
                <div class="productoInfoContainer">
                    <!-- <pre>{{ JSON.stringify(product, null, 2) }}</pre> -->
                    <h1>{{ product.titulo }}</h1>
                    <h2>{{ product.subtitulo }}</h2>
                    <div
                        class="descripcionProdContainer"
                        v-html="product.descripcion"
                    ></div>
                    <div class="btnContainer pc">
                        <a href="https://wa.link/i0xeew" target="_blank">
                            <img :src="icon" alt="" />
                            <span>Consultar por Whatsapp</span>
                        </a>
                        <button
                            @click="
                                openCotizacion(
                                    product.titulo,
                                    product.cover_image,
                                )
                            "
                        >
                            Pide tu cotización
                        </button>
                    </div>

                    <div class="caracetisticasContainer">
                        <h3>Especificaciones técnicas:</h3>
                        <div class="tablaContainer">
                            <!-- ====================== DIMENSIONES GENERALES (Especial) ====================== -->
                            <div v-if="dimensionesGenerales.length > 0">
                                <div class="rowContainer">
                                    <h4>Dimensiones Generales</h4>
                                    <div
                                        v-for="feature in dimensionesGenerales"
                                        :key="feature.id"
                                        class="itemContainer"
                                    >
                                        <div>{{ feature.name }}</div>
                                        <div>
                                            {{ feature.pivot?.value || "—" }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ====================== RESTO DE CARACTERÍSTICAS (como antes) ====================== -->
                            <div
                                class="rowContainer"
                                v-for="feature in otherFeatures"
                                :key="feature.id"
                            >
                                <h4>{{ feature.group }}</h4>
                                <div>
                                    <div
                                        class="itemContainer"
                                        v-if="feature.type === 'text'"
                                    >
                                        <div>{{ feature.name }}</div>
                                        <div>{{ feature.pivot.value }}</div>
                                    </div>
                                    <div
                                        class="itemContainer itemColoresContainer"
                                        v-else-if="feature.id === 7"
                                    >
                                        <!-- para los colores  -->
                                        <div
                                            v-for="(item, i) in parseValue(
                                                feature.pivot?.value,
                                            )"
                                            :key="i"
                                            :style="{
                                                backgroundColor:
                                                    getColorCode(item),
                                            }"
                                        ></div>
                                    </div>
                                    <div v-else>
                                        <div
                                            class="itemContainer"
                                            v-for="(item, i) in parseValue(
                                                feature.pivot?.value,
                                            )"
                                            :key="i"
                                        >
                                            <div>{{ item }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rowContainer">
                                <a
                                    :href="`/storage/${product.technical_document}`"
                                    target="_blank"
                                    class="btnTransparente"
                                    >Descarga Ficha Técnica</a
                                >
                            </div>
                        </div>
                    </div>
                    <div class="btnContainer movil">
                        <a href="https://wa.link/i0xeew" target="_blank">
                            <img :src="icon" alt="" />
                            <span>Consultar por Whatsapp</span>
                        </a>
                        <button
                            @click="
                                openCotizacion(
                                    product.titulo,
                                    product.cover_image,
                                )
                            "
                        >
                            Pide tu cotización
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { inject } from "vue";
import { Splide, SplideSlide } from "@splidejs/vue-splide";
import { ref, onMounted, computed } from "vue";
const openCotizacion = inject("openCotizacion");
const icon = "/images/icow.svg";
// Opciones para slider principal
const mainOptions = {
    type: "fade",
    rewind: true,
    pagination: false,
    arrows: true,
    heightRatio: 1.2, // ajusta según tus imágenes
};

// Opciones para miniaturas
const thumbnailOptions = {
    fixedWidth: 160,
    fixedHeight: 210,
    gap: 10,
    rewind: true,
    pagination: false,
    isNavigation: true, // importante para sincronizar
    focus: "center",
    // Flechas por defecto (para PC)
    arrows: true,
    // === CONFIGURACIÓN RESPONSIVE ===
    breakpoints: {
        768: {
            arrows: false,
            destroy: true, // ← Esto destruye completamente el slider en mobile
        },
    },
};
const mainSplide = ref(null);

const thumbnailSplide = ref(null);

const goToSlide = (index) => {
    if (thumbnailSplide.value) {
        thumbnailSplide.value.go(index);
    }
};

onMounted(() => {
    // Sincronización entre ambos sliders (opcional pero recomendado)
    if (mainSplide.value && thumbnailSplide.value) {
        mainSplide.value.sync(thumbnailSplide.value.splide);
    }
});

// Computed para separar Dimensiones Generales
const dimensionesGenerales = computed(() => {
    return props.product.features.filter(
        (f) => f.group === "Dimensiones Generales",
    );
});

const otherFeatures = computed(() => {
    return props.product.features.filter(
        (f) => f.group !== "Dimensiones Generales",
    );
});

// Obtener thumbnail de YouTube
const getYoutubeThumbnail = (url) => {
    if (!url) return "";
    const videoId = url.split("v=")[1] || url.split("/").pop();
    return `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
};

const getYoutubeEmbedUrl = (url) => {
    if (!url) return "";
    let videoId = url.split("v=")[1] || url.split("/").pop();
    videoId = videoId.split("?")[0]; // limpiar parámetros
    return `https://www.youtube.com/embed/${videoId}?modestbranding=1&rel=0`;
};

// Función para parsear el valor
const parseValue = (value) => {
    if (!value) return [];
    try {
        const parsed = JSON.parse(value);
        return Array.isArray(parsed) ? parsed : [parsed];
    } catch (e) {
        return [value]; // si falla, devolvemos el valor original
    }
};
// 2. Función para obtener el código HEX según el nombre del color
const getColorCode = (colorName) => {
    // Buscamos en todas las options de la feature "Colores"
    console.log(props);
    const feature = props.product.features.find((f) => f.id === 7);
    if (!feature || !feature.options) return "#9ca3af"; // gris por defecto

    const option = feature.options.find(
        (opt) => opt.value.toLowerCase() === colorName.toLowerCase(),
    );

    return option?.codigo || "#9ca3af";
};
const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    category: {
        type: Object,
        default: null,
    },
});
</script>

<style scoped>
.thumbnail-slider {
    margin-top: 1rem;
}
.main-slider {
    height: 100%;
}
.productoViewContainer {
    overflow: hidden;
    border-radius: 20px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: #f1f1f1;
}
.productoViewContainer video {
    width: 100%;
}
.productoViewContainer.negro {
    background: #000;
}
.main-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
}
.thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 2px solid transparent;
    border-radius: 4px;
    cursor: pointer;
}
/* .thumbnail:hover,
.thumbnail.is-active {
    border-color: #084DA6; 
} */

.splide__track--nav > .splide__list > .splide__slide.is-active {
    border: 3px solid #084da6;
}
.thumbnail-item {
    width: 160px;
    height: 210px;
    border: 3px solid transparent;
    border-radius: 8px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
}
.thumbnail-video {
    width: 100%;
    height: 100%;
    overflow: hidden;
    background: #000;
}

.thumbnail-video video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.thumbnail-item.active {
    border-color: #f59e0b;
}

.thumbnail-item img,
.thumbnail-item video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.thumbnail-youtube {
    width: 100%;
    height: 100%;
    overflow: hidden;
    background: #000;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.play-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0, 0, 0, 0.6);
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}
/* En móviles ocultamos todo el thumbnail slider */
@media (max-width: 992px) {
    .thumbnail-slider {
        display: none !important;
    }
}

@media screen and (min-width: 992px) {
    .productoViewContainer,
    .main-slider {
        height: 600px;
    }
}
</style>
