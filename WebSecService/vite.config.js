import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'; // Add this line

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss', // Ensure this line is present
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'), // Add this line
        },
    },
});