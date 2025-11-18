import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',

                'resources/css/custom.css',

                'resources/js/layouts/main.js',
                'resources/js/layouts/custom-switcher.js',
                'resources/js/layouts/default-menu.js',

                'resources/js/pages/auth/login.js',
                'resources/js/pages/auth/register.js',
                'resources/js/pages/auth/email.js',
                'resources/js/pages/auth/reset.js',
                'resources/js/pages/auth/confirm.js',

                'resources/js/pages/company/index.js',
                'resources/js/pages/event/categories/index.js',

                'resources/js/pages/event/event/index.js',

                'resources/js/pages/event/calendar/index.js',

                'resources/js/pages/event/upcoming/index.js',

                'resources/js/pages/approval/user/index.js',
                'resources/js/pages/approval/event/index.js',
                'resources/js/pages/approval/event/show.js',

                'resources/js/pages/setting/permission/index.js',
                'resources/js/pages/setting/permission/edit.js',
            ],
            refresh: true,
        }),
    ],
});
