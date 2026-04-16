import { createApp, h } from 'vue'
import './bootstrap';
import { createInertiaApp } from '@inertiajs/vue3'
import { createHead } from '@vueuse/head'   // ← Correcto para vueuse/head

import { Link } from '@inertiajs/vue3'

import FrontLayout from './layouts/FrontLayout.vue';
import '../scss/main.scss'

// Import Ziggy
import * as ZiggyModule from './ziggy'
const Ziggy = ZiggyModule.Ziggy || {}

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        let page = pages[`./Pages/${name}.vue`]

        if (page.default) {
            page.default.layout = page.default.layout || FrontLayout
        }

        return page
    },

    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })

        app.use(plugin)
        app.component('Link', Link)

        // Función route mejorada y sin warnings molestos
        const route = (name, params = {}, absolute = false) => {
            if (!name) return '/';
            if (typeof name === 'string' && name.startsWith('/')) return name;

            // Intentar con Ziggy primero
            try {
                if (Ziggy && Ziggy.route) {
                    return Ziggy.route(name, params, absolute);
                }
            } catch (e) {
                // Silencioso - solo fallback
            }

            // Fallback manual (esto es lo que realmente está funcionando)
            if (name === 'home') return '/';
            if (name === 'nosotros') return '/nosotros';
            if (name === 'category.show') {
                const slug = params.slug || params[0] || 'lockers';
                return `/categoria/${slug}`;
            }
            if (name === 'category.show') {
                const slug = params.slug || params[0] || params.category_slug || 'lockers';
                return `/categoria/${slug}`;
            }
            if (name === 'product.show') {
                const category_slug = params.category_slug || params[0];
                const product_slug = params.product_slug || params[1];

                if (category_slug && product_slug) {
                    return `/producto/${category_slug}/${product_slug}`;
                }
            }

            return `/${name}`;
        };

        // Registrar de forma global
        window.$route = route;
        app.config.globalProperties.$route = route;
        app.config.globalProperties.route = route;

        app.mixin({
            methods: {
                route
            }
        });

        // Configuración correcta para Unhead v3
        const head = createHead()
        app.use(head)

        app.mount(el)
    },

    progress: {
        color: '#4B5563',
    },
})