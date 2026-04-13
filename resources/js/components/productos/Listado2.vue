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
                        <div class="mantaFiltro">
                            <div class="headerContainer" id="header-1" @click="toggleManta(1)">
                                <h3>Material</h3>
                                <div class="iconContainer">
                                    <img :src="iconarrow" alt="">
                                </div>
                            </div>
                            <div class="opcionesContainer" id="opciones-1">
                                <label v-for="material in materiales" :key="material.id" class="checkbox-item">
                                    <input 
                                        type="checkbox" 
                                        :value="material.slug"
                                        v-model="selectedMateriales"
                                        @change="applyFilters"
                                    />
                                    <span class="checkmark"></span>
                                    {{ material.name }}
                                    <!-- <span class="count">({{ cerradura.count }})</span> -->
                                </label>
                            </div>
                        </div>
                      
                    </div>
                </aside>
                <!-- LISTADO DE PRODUCTOS (lado derecho) -->
                <section class="products-content">
                    <!-- Aquí tu grid o lista de productos -->
                     <div class="products-grid">
                        <div class="cardProducts" v-for="(item, index) in products" :key="index">
                            <div class="imgContainer">
                                <img :src="item.imagen" :alt="item.titulo" />
                            </div>
                            <div class="dataContainer">
                                <h3>{{item.categoria}}</h3>
                                <h2>{{item.titulo}}</h2>
                                <a :href="item.link" class="btnRelleno">
                                    Ver detalles
                                </a>
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
const iconarrow = '/images/iconarrow.svg'
const products = ref([
    {
        imagen: '/images/p1.webp',
        link: '/',
        titulo: `Locker LP01-04 / 4 Puertas`,
        categoria: `LOCKER DE PLÁSTICO`,
    },
    {
        imagen: '/images/p2.webp',
        link: '/',
        titulo: `Cartón corrugado`,
        categoria: `MATERIAL DE EMBALAJE`,
    },
    {
        imagen: '/images/p3.webp',
        link: '/',
        titulo: `Cinta de embalaje`,
        categoria: `INSUMOS`,
    },
    {
        imagen: '/images/p4.webp',
        link: '/',
        titulo: `Strech film`,
        categoria: `INSUMOS`,
    },
    {
        imagen: '/images/p1.webp',
        link: '/',
        titulo: `Strech film`,
        categoria: `INSUMOS`,
    }
   
])
const materiales = ref([
    { id: 1, name: 'Cartón corrugado', count: 45, slug: 'azul' },
    { id: 2, name: 'Cinta de embalaje', count: 45, slug: 'rojo' },
    { id: 3, name: 'Strech film', count: 45, slug: 'verde' },
])

const selectedMateriales = ref([]);
// Función que se llama cuando cambian los filtros
const applyFilters = () => {
    // Aquí haces la petición a Laravel (Inertia o Axios)
    console.log('Filtros aplicados:', {
        materiales: selectedMateriales.value,
    })
}

// Opcional: Watch para aplicar filtros automáticamente
watch([selectedMateriales], () => {
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