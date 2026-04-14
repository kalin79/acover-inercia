<template>
    <main class="products-page">
        <div class="containerFluid">
            <div class="products-wrapper">
                
                <!-- FILTROS (lado izquierdo) -->
                <aside class="filters-sidebar">
                    <div class="filters-inner">
                        <!-- Aquí va todo tu formulario de filtros (puede ser largo) -->
                         <div class="headerFiltro">
                            <h3>Filtros</h3>
                            <button>Limpiar</button>
                         </div>
                        <!-- categorías, rango de precio, marcas, etc. -->
                        <div class="mantaFiltro">
                            <h3>Buscar por:</h3>
                            <div class="rowForm">
                                <input type="text" placeholder="¿Qué buscas?" />
                            </div>
                        </div>
                        <div class="mantaFiltro" 
                            v-for="feature in category.features"
                            :key="feature.id"
                        >
                            <div class="headerContainer" :id="`header-${feature.id}`" @click="toggleManta(feature.id)">
                                <h3>{{feature.name}}</h3>
                                <div class="iconContainer">
                                    <img :src="iconarrow" alt="">
                                </div>
                            </div>
                            <div class="opcionesContainer" :id="`opciones-${feature.id}`">
                                <label v-for="option in feature.options" :key="option.id" class="checkbox-item">
                                    <input 
                                        type="checkbox" 
                                        :value="option.id"
                                        v-model="selectedColores"
                                        @change="applyFilters"
                                    />
                                    <span class="checkmark"></span>
                                    {{ option.value }}
                                    <!-- <span class="count">({{ color.count }})</span> -->
                                </label>
                            </div>
                        </div>
                    </div>
                </aside>
                <!-- LISTADO DE PRODUCTOS (lado derecho) -->
                <section class="products-content">
                    <!-- Aquí tu grid o lista de productos -->
                     <!-- <pre>{{ JSON.stringify(category, null, 2) }}</pre> -->
                     <div class="products-grid">
                        <div class="cardProducts" v-for="(item, index) in products" :key="index">
                            <div class="imgContainer">
                                <img :src="`/storage/${item.cover_image}`" :alt="item.titulo" />
                            </div>
                            <div class="dataContainer">
                                <h3>{{category.titulo}}</h3>
                                <h2>{{item.titulo}}</h2>
                                <Link :href="route('product.show', {category_slug: category.slug,product_slug: item.slug})" class="btnRelleno">
                                    Ver detalles
                                </Link>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
</template>
<script setup>
import { ref, watch } from 'vue'
import { Link } from '@inertiajs/vue3'
const iconarrow = '/images/iconarrow.svg'

const props = defineProps({
    products: {
        type: Object,
        required: true
    },
    category: {
        type: Object,
        default: null
    }
});


const colores = ref([
    { id: 1, name: 'Azul', count: 45, slug: 'azul' },
    { id: 2, name: 'Rojo', count: 45, slug: 'rojo' },
    { id: 3, name: 'Verde', count: 45, slug: 'verde' },
    { id: 4, name: 'Gris', count: 45, slug: 'gris' },
])

const cerraduras = ref([
    { id: 1, name: 'Cerradura con llave', count: 45, slug: 'llave' },
])

const puertas = ref([
    { id: 1, name: '3 puertas', count: 45, slug: '3-puertas' },
    { id: 2, name: '4 puertas', count: 45, slug: '4-puertas' },
])

const columnas = ref([
    { id: 1, name: '1 columna', count: 45, slug: '1-columna' },
    { id: 2, name: '2 columnas', count: 45, slug: '2-columnas' },
    { id: 3, name: '3 columnas', count: 45, slug: '3-columnas' },
    { id: 4, name: '4 columnas', count: 45, slug: '4-columnas' },
    { id: 5, name: '5 columnas', count: 45, slug: '5-columnas' },
])

const selectedColores = ref([]);
const selectedCerraduras = ref([]);
const selectedPuertas = ref([]);
const selectedColumnas = ref([]);
// Función que se llama cuando cambian los filtros
const applyFilters = () => {
    // Aquí haces la petición a Laravel (Inertia o Axios)
    console.log('Filtros aplicados:', {
        colores: selectedColores.value,
        cerraduras: selectedCerraduras.value,
        puertas: selectedPuertas.value,
        columnas: selectedColumnas.value
    })
}

// Opcional: Watch para aplicar filtros automáticamente
watch([selectedColores, selectedCerraduras, selectedPuertas, selectedColumnas], () => {
  applyFilters()
})

const toggleManta = (id) => {
    const element = document.getElementById(`header-${id}`);
    const elementContenido = document.getElementById(`opciones-${id}`);
    if (!element) return
    // ✅ Verificar si existe la clase
    const tieneClase = element.classList.contains('cerrar')
    if (tieneClase) {
        // console.log('La clase active SÍ existe')
        element.classList.remove('cerrar')
        elementContenido.classList.remove('cerrar')
        
    } else {
        // console.log('La clase active NO existe')
        element.classList.add('cerrar')
        elementContenido.classList.add('cerrar')
    }
}
</script>