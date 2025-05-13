import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/datatables.js",
                "resources/js/filepond.js",
                "resources/js/telInput.js",
                "resources/js/choices.js",
                "resources/js/calculate.js",
                "resources/js/calculate2.js",
                "resources/js/chart.js",
            ],
            refresh: true,
        }),
    ],
});
