<template>
    <main class="products-page">
        <div class="containerFluid">
            <div class="products-wrapper">

                <!-- FILTROS DINÁMICOS -->
                <aside class="filters-sidebar">
                    <div class="filters-inner">
                        <div class="headerFiltro">
                            <!-- <pre>{{ JSON.stringify(filterableFeatures, null, 2) }}</pre> -->
                            <h3>Filtros</h3>
                            <button @click="clearFilters">Limpiar</button>
                        </div>
                        <div class="mantaFiltro">
                            <h3>Buscar por:</h3>
                            <div class="rowForm">
                                <input 
                                    type="text" 
                                    placeholder="¿Qué buscas?" 
                                    v-model="searchTerm"
                                    @keyup.enter="applySearch"
                                />
                            </div>
                        </div>
                        <div 
                            v-for="feature in filterableFeatures" 
                            :key="feature.id" 
                            class="mantaFiltro"
                        >
                            <div class="headerContainer" :id="`header-${feature.id}`" @click="toggleManta(feature.id)">
                                <h3>{{ feature.name }}</h3>
                                <div class="iconContainer">
                                    <img :src="iconarrow" alt="">
                                </div>
                            </div>

                            <div class="opcionesContainer" :id="`opciones-${feature.id}`">
                                <label 
                                    v-for="option in feature.options" 
                                    :key="option.id" 
                                    class="checkbox-item"
                                >
                                    <input 
                                        type="checkbox" 
                                        :value="option.id"                 
                                        :checked="isSelected(feature.group, option.id)"
                                        @change="toggleOption(feature.group, option.id)"
                                    />
                                    <span class="checkmark"></span>
                                    {{ option.value }}
                                </label>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- LISTADO DE PRODUCTOS -->
                <section class="products-content">
                    <!-- <pre>Debug - Total: {{ products.total }} | Length: {{ products.data?.length || 0 }}</pre> -->

                    <div 
                        class="products-grid" 
                        :key="'grid-' + JSON.stringify(selectedFilters) + '-' + Date.now()"
                    >
                        <div v-if="products.data && products.data.length > 0">
                            <div 
                                class="cardProducts" 
                                v-for="item in products.data" 
                                :key="item.id"
                            >
                                <div class="imgContainer">
                                    <img 
                                        v-if="item.cover_image"
                                        :src="`/storage/${item.cover_image}`" 
                                        :alt="item.titulo" 
                                    />
                                    <div v-else style="height:200px; background:#f5f5f5; display:flex; align-items:center; justify-content:center;">
                                        Sin imagen
                                    </div>
                                </div>
                                <div class="dataContainer">
                                    <h3>{{ category.titulo }}</h3>
                                    <h2>{{ item.titulo }}</h2>
                                    <Link 
                                        :href="`/producto/${category.slug}/${item.slug}`" 
                                        class="btnRelleno"
                                    >
                                        Ver detalles
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <div v-else class="no-results" style="padding: 80px 20px; text-align: center; background: #fff3cd; border: 2px solid #ffeaa7; border-radius: 12px; margin: 30px 0;">
                            <h3>😕 No se encontraron productos</h3>
                            <p>Ningún producto coincide con los filtros seleccionados.</p>
                            <button @click="clearFilters" style="margin-top: 20px; padding: 12px 28px; background: #007bff; color: white; border: none; border-radius: 8px;">
                                Limpiar filtros
                            </button>
                        </div>
                    </div>
                    <!-- <pre>{{ JSON.stringify(products, null, 2) }}</pre> -->
                    <div v-if="products.data && products.data.length > 0" class="pagination">
                        <Link v-if="products.prev_page_url" :href="products.prev_page_url">Anterior</Link>
                        <span>Página {{ products.current_page }} de {{ products.last_page }}</span>
                        <Link v-if="products.next_page_url" :href="products.next_page_url">Siguiente</Link>
                    </div>
                </section>
            </div>
        </div>
    </main>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    category: { type: Object, required: true },
    products: { type: Object, required: true },
    filters: { type: Object, default: () => ({}) }
})

const iconarrow = '/images/iconarrow.svg'

const searchTerm = ref('')                    // ← Esta era la línea que faltaba

const selectedFilters = ref({})

const normalizeGroup = (group) => group ? group.replace(/_/g, ' ') : group;

const getFiltersFromUrl = () => {
    const params = new URLSearchParams(window.location.search)
    const filters = {}

    params.forEach((value, key) => {
        if (key.endsWith('[]')) {
            const group = normalizeGroup(key.replace('[]', ''))
            if (!filters[group]) filters[group] = []
            filters[group].push(value)
        }
    })

    return filters
}

const filterableFeatures = computed(() => {
    return props.category.features.filter(f => f.type === 'select')
})

const isSelected = (group, value) => {
    const normalizedGroup = normalizeGroup(group)
    return Array.isArray(selectedFilters.value[normalizedGroup]) 
        ? selectedFilters.value[normalizedGroup].includes(String(value)) 
        : false
}

const toggleOption = (group, value) => {
    const normalizedGroup = normalizeGroup(group)

    if (!selectedFilters.value[normalizedGroup]) {
        selectedFilters.value[normalizedGroup] = []
    }

    const index = selectedFilters.value[normalizedGroup].indexOf(String(value))

    if (index === -1) {
        selectedFilters.value[normalizedGroup].push(String(value))
    } else {
        selectedFilters.value[normalizedGroup].splice(index, 1)
    }

    applyFilters()
}

const applyFilters = () => {
    let queryParts = []

    Object.keys(selectedFilters.value).forEach(group => {
        const values = selectedFilters.value[group]
        if (Array.isArray(values) && values.length > 0) {
            values.forEach(value => {
                queryParts.push(`${encodeURIComponent(group)}[]=${encodeURIComponent(value)}`)
            })
        }
    })

    const queryString = queryParts.join('&')
    const url = `/categoria/${props.category.slug}${queryString ? '?' + queryString : ''}`

    window.location.href = url
}

const clearFilters = () => {
    selectedFilters.value = {}
    window.location.href = `/categoria/${props.category.slug}`
}

const toggleManta = (id) => {
    const header = document.getElementById(`header-${id}`)
    const content = document.getElementById(`opciones-${id}`)
    if (header && content) {
        header.classList.toggle('cerrar')
        content.classList.toggle('cerrar')
    }
}

onMounted(() => {
    selectedFilters.value = getFiltersFromUrl()
})
</script>