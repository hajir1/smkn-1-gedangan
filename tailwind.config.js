import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/Cms/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                // Biru tua khas seragam & identitas sekolah
                brand: {
                    50: '#eef4fb', 100: '#d9e5f4', 200: '#b6cbe8', 300: '#87a7d6', 400: '#557cbf',
                    500: '#355ea6', 600: '#26498a', 700: '#1f3b70', 800: '#1b315c', 900: '#172a4c', 950: '#0d1a31',
                },
                // Aksen emas
                gold: {
                    50: '#fdf8ec', 100: '#f9ecc9', 200: '#f2d68e', 300: '#ebbd55', 400: '#e5a82f',
                    500: '#d68b1a', 600: '#b96b13', 700: '#994f14', 800: '#7d3f17', 900: '#683516',
                },
                paper: '#f7f5f0',
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                display: ['Fraunces', ...defaultTheme.fontFamily.serif],
            },
        },
    },
    plugins: [forms],
};
