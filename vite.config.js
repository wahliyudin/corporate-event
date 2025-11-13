import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',

                'resources/css/custom.css',

                'resources/js/layouts/main.js',
                'resources/js/layouts/custom-switcher.js',
                'resources/js/layouts/default-menu.js',

                'resources/js/pages/event/index.js',
            ],
            refresh: true,
        }),
    ],
});
