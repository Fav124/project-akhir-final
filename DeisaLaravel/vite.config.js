import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/deisa.css', 'resources/js/app.js'],
            refresh: [
                'resources/views/**',
                'app/**',
                'routes/**',
            ],
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true,
            ignored: ['**/storage/framework/views/**', '**/node_modules/**', '**/vendor/**'],
        },
    },
    build: {
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            input: {
                deisa: 'resources/css/deisa.css',
                app: 'resources/js/app.js',
            },
        },
    },
});
