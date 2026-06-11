import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/auth.js',
                'resources/js/materialize/config.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '127.0.0.1',
        port: 5173,
        strictPort: true,
        cors: true,
        hmr: {
            host: '127.0.0.1',
        },
    },
    build: {
        rollupOptions: {
            output: {
                assetFileNames: assetInfo => {
                    if (assetInfo.name && assetInfo.name.startsWith('materialize/')) {
                        return `assets/${assetInfo.name}`;
                    }
                    return 'assets/[name]-[hash][extname]';
                },
            },
        },
    },
});
