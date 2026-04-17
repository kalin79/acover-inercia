import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import inertia from '@inertiajs/vite';
import path from 'path';
import svgLoader from 'vite-svg-loader';   // ← Agregar esto
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css','resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        svgLoader(),     // ← Agregar esta línea
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources'),   // ← Recomendado
        },
    },

});