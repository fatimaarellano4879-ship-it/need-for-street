
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import path from 'node:path';

const root = path.resolve(process.cwd());

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/assets/css/demo.css',
                'resources/js/app.js',
                'resources/assets/vendor/scss/core.scss',
                'resources/assets/vendor/fonts/iconify/iconify.css',
                'resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.scss',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],

    resolve: {
        alias: {
            '@': root + '/resources',
        },
    },
});
