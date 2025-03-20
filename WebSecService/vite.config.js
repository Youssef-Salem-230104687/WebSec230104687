import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/sass/app.scss',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            'sass': path.resolve(__dirname, 'resources/sass')
        }
    },
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@import "resources/sass/app.scss";`
            }
        }
    }
});
