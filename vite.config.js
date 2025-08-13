import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        vue(),
    ],
    server: {
        host: '0.0.0.0', // supaya bisa diakses dari luar localhost
        hmr: {
            host: 'b8fdc4f7d830.ngrok-free.app', // ganti dengan domain ngrok kamu
            protocol: 'wss', // pakai wss biar aman di HTTPS
        }
    },
    base: '/',
});
