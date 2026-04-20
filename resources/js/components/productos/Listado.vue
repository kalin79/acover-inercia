<template>
    <main class="products-page">
        <div class="containerFluid">
            <div class="products-wrapper">
                <!-- {{JSON.stringify(filterableFeatures, null, 2)}} -->
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
                                    @input="handleSearchInput"
                                />
                            </div>
                        </div>
                        <div
                            v-for="feature in filterableFeatures"
                            :key="feature.id"
                            class="mantaFiltro"
                        >
                            <div
                                class="headerContainer"
                                :id="`header-${feature.id}`"
                                @click="toggleManta(feature.id)"
                            >
                                <h3>{{ feature.name }}</h3>
                                <div class="iconContainer">
                                    <img :src="iconarrow" alt="" />
                                </div>
                            </div>

                            <div
                                class="opcionesContainer"
                                :id="`opciones-${feature.id}`"
                            >
                                <label
                                    v-for="option in feature.options"
                                    :key="option.id"
                                    class="checkbox-item"
                                >
                                    <input
                                        type="checkbox"
                                        :value="option.id"
                                        :checked="
                                            isSelected(feature.group, option.id)
                                        "
                                        @change="
                                            toggleOption(
                                                feature.group,
                                                option.id,
                                            )
                                        "
                                    />
                                    <span class="checkmark"></span>
                                    {{ option.value }}
                                </label>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- FILTROS DINAMICOS PARA MOVIL -->
                <div class="filters-containerM">
                    <button
                        class="filters-headerM"
                        @click="isFiltersOpen = !isFiltersOpen"
                    >
                        <div class="filterHeaderTitle">
                            <div class="filers-iconFiltrado">
                                <img :src="iconFil" alt="" />
                            </div>
                            <span>Filtros</span>
                        </div>
                        <div
                            class="filters-arrow"
                            :class="{ open: isFiltersOpen }"
                        >
                            <img :src="filArrow" alt="" />
                        </div>
                    </button>
                    <!-- Panel de filtros -->
                    <div v-if="isFiltersOpen" class="filters-panelM">
                        <!-- Sección Color -->
                        <div
                            class="filter-sectionM"
                            v-for="feature in filterableFeatures"
                            :key="feature.id"
                        >
                            <div
                                class="section-headerM"
                                @click="toggleSection(feature.id)"
                                :class="{
                                    collapsed: !isSectionOpen(feature.id),
                                }"
                            >
                                <span>{{ feature.name }}</span>
                                <div class="iconFill">
                                    <img
                                        :src="filArrow"
                                        :class="{
                                            open: isSectionOpen(feature.id),
                                        }"
                                        alt=""
                                    />
                                </div>
                            </div>
                            <div
                                class="checkbox-groupM"
                                :class="{
                                    collapsed: !isSectionOpen(feature.id),
                                }"
                            >
                                <label
                                    v-for="option in feature.options"
                                    :key="option.id"
                                    class="checkbox-labelM"
                                >
                                    <input
                                        type="checkbox"
                                        :value="option.id"
                                        :checked="
                                            isSelected(feature.group, option.id)
                                        "
                                        @change="
                                            toggleOption(
                                                feature.group,
                                                option.id,
                                            )
                                        "
                                    />
                                    <span class="color-dotM"></span>
                                    {{ option.value }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contador -->
                <p class="results-count">
                    Se han encontrado {{ productsList.length }} productos.
                </p>

                <!-- LISTADO DE PRODUCTOS -->
                <section class="products-content">
                    <!-- <pre>Debug - Total: {{ products.total }} | Length: {{ products.data?.length || 0 }}</pre> -->

                    <div
                        class="products-list"
                        :key="
                            'grid-' +
                            JSON.stringify(selectedFilters) +
                            '-' +
                            Date.now()
                        "
                    >
                        <div
                            class="products-grid"
                            v-if="productsList && productsList.length > 0"
                        >
                            <div
                                class="cardProducts"
                                v-for="product in productsList"
                                :key="product.id"
                            >
                                <div class="imgContainer">
                                    <img
                                        v-if="product.cover_image"
                                        :src="`/storage/${product.cover_image}`"
                                        :alt="product.titulo"
                                    />
                                    <div
                                        v-else
                                        style="
                                            height: 200px;
                                            background: #f5f5f5;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                        "
                                    >
                                        Sin imagen
                                    </div>
                                </div>
                                <div class="dataContainer">
                                    <h3>{{ category.titulo }}</h3>
                                    <h2>{{ product.titulo }}</h2>
                                    <Link
                                        :href="`/producto/${category.slug}/${product.slug}`"
                                        class="btnRelleno"
                                    >
                                        Ver detalles
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <div
                            v-else
                            class="no-results"
                            style="
                                padding: 80px 20px;
                                text-align: center;
                                background: #fff3cd;
                                border: 2px solid #ffeaa7;
                                border-radius: 12px;
                                margin: 30px 0;
                            "
                        >
                            <h3>😕 No se encontraron productos</h3>
                            <p>
                                Ningún producto coincide con los filtros
                                seleccionados.
                            </p>
                            <button
                                @click="clearFilters"
                                style="
                                    margin-top: 20px;
                                    padding: 12px 28px;
                                    background: #007bff;
                                    color: white;
                                    border: none;
                                    border-radius: 8px;
                                "
                            >
                                Limpiar filtros
                            </button>
                        </div>
                    </div>
                    <!-- <pre>{{ JSON.stringify(productsList, null, 2) }}</pre> -->
                    <!-- Paginación -->
                    <div
                        v-if="pagination.last_page > 1"
                        class="pagination-container"
                    >
                        <button
                            @click="goToPage(pagination.current_page - 1)"
                            :disabled="pagination.current_page === 1"
                            class="pagination-btn"
                        >
                            ← Anterior
                        </button>

                        <span class="page-info">
                            Página {{ pagination.current_page }} de
                            {{ pagination.last_page }} ({{ pagination.total }}
                            productos)
                        </span>

                        <button
                            @click="goToPage(pagination.current_page + 1)"
                            :disabled="
                                pagination.current_page === pagination.last_page
                            "
                            class="pagination-btn"
                        >
                            Siguiente →
                        </button>
                    </div>
                </section>
            </div>
        </div>
    </main>
</template>
<script setup>
import { ref, computed, watch, onMounted } from "vue";
import axios from "axios";

const iconFil = "/images/fil.svg";
const filArrow = "/images/filarrow.svg";

const props = defineProps({
    category: { type: Object, required: true },
});

const iconarrow = "/images/iconarrow.svg";

// Estado reactivo
const isFiltersOpen = ref(false);

// Estado para controlar qué secciones están abiertas
const openSections = ref({});

// Inicializar todas las secciones como abiertas por defecto
const initializeOpenSections = () => {
    filterableFeatures.value.forEach((feature) => {
        openSections.value[feature.id] = false;
    });
};

// Toggle para abrir/cerrar
const toggleSection = (featureId) => {
    openSections.value[featureId] = !openSections.value[featureId];
};
// Helper para saber si está abierta
const isSectionOpen = (featureId) => {
    return openSections.value[featureId] !== false; // true por defecto
};
// Estados principales
const productsList = ref([]);
const loading = ref(false);
const searchTerm = ref("");

const pagination = ref({
    current_page: 1,
    last_page: 1,
    total: 0,
    per_page: 12,
    from: 0,
    to: 0,
});

// Filtros seleccionados
const selectedFilters = ref({});

// Features filtrables (solo tipo "select")
const filterableFeatures = computed(() => {
    return props.category.features.filter((f) => f.type === "select");
});

// ==================== BÚSQUEDA EN TIEMPO REAL ====================
const searchTimeout = ref(null);

const handleSearchInput = () => {
    if (searchTimeout.value) clearTimeout(searchTimeout.value);

    searchTimeout.value = setTimeout(() => {
        fetchProducts();
    }, 400); // 400ms de debounce
};

// ==================== MANEJO DE FILTROS ====================
const isSelected = (group, value) => {
    return selectedFilters.value[group]?.includes(String(value)) || false;
};

const toggleManta = (id) => {
    const headerContainer = document.getElementById(`header-${id}`);
    const bodyContainer = document.getElementById(`opciones-${id}`);
    if (headerContainer.classList.contains("cerrar")) {
        headerContainer.classList.remove("cerrar");
        bodyContainer.classList.remove("cerrar");
    } else {
        headerContainer.classList.add("cerrar");
        bodyContainer.classList.add("cerrar");
    }
};

const toggleOption = (group, value) => {
    const normalizedGroup = group.replace(/_/g, " ");

    if (!selectedFilters.value[normalizedGroup]) {
        selectedFilters.value[normalizedGroup] = [];
    }

    const index = selectedFilters.value[normalizedGroup].indexOf(String(value));

    if (index === -1) {
        selectedFilters.value[normalizedGroup].push(String(value));
    } else {
        selectedFilters.value[normalizedGroup].splice(index, 1);
    }

    // Limpiar grupo vacío
    if (selectedFilters.value[normalizedGroup].length === 0) {
        delete selectedFilters.value[normalizedGroup];
    }

    fetchProducts();
};

// ==================== CARGAR PRODUCTOS ====================
const fetchProducts = async (page = null) => {
    loading.value = true;

    try {
        const params = {
            category_slug: props.category.slug, // ← ESTO ES CLAVE
            ...selectedFilters.value,
            page: page || pagination.value.current_page,
        };

        if (searchTerm.value?.trim().length >= 3) {
            params.search = searchTerm.value.trim();
        }

        console.log("🔄 Enviando petición:", params);
        console.log({ params });

        const response = await axios.get("/api/products/filter", { params });

        if (response.data.success) {
            productsList.value = response.data.data || [];

            pagination.value = {
                current_page: response.data.current_page || 1,
                last_page: response.data.last_page || 1,
                total: response.data.total || 0,
                per_page: response.data.per_page || 12,
                from: response.data.from || 0,
                to: response.data.to || 0,
            };
            console.log(productsList);
            console.log(
                `✅ Cargados ${productsList.value.length} productos | Página ${pagination.value.current_page}/${pagination.value.last_page}`,
            );
        } else {
            productsList.value = [];
        }
    } catch (error) {
        console.error(
            "❌ Error al cargar productos:",
            error.response?.data || error.message,
        );
        productsList.value = [];
    } finally {
        loading.value = false;
    }
};

// ==================== CAMBIAR DE PÁGINA ====================
const goToPage = (page) => {
    if (page < 1 || page > pagination.value.last_page) return;
    fetchProducts(page);
};

// ==================== LIMPIAR FILTROS ====================
const clearFilters = () => {
    selectedFilters.value = {};
    searchTerm.value = "";
    fetchProducts(1);
};

// ==================== INICIALIZACIÓN ====================
onMounted(() => {
    initializeOpenSections();
    fetchProducts();
});

// Watch para filtros (por si quieres reactividad extra)
watch(
    selectedFilters,
    () => {
        fetchProducts(1);
    },
    { deep: true },
);
</script>
