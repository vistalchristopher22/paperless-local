import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    // server: {
    //     host: 'paperless.test',
    // },
    resolve: {
        alias: {
            "@": "/resources/js",
            "@common": "/resources/js/common",
            "@components": "/resources/js/components",
            "@pages": "/resources/js/Pages",
            "@css": "/resources/css",
            "@services": "/resources/js/services",
        },
    },
    plugins: [
        vue(),
        laravel({
            input: ["resources/js/app.js"],
            refresh: true,
        }),
    ],
});
