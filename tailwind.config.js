import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                    950: '#082f49',
                },
                accent: {
                    50: '#fdfceb',
                    100: '#fbf8c7',
                    200: '#f7f191',
                    300: '#f2e350',
                    400: '#edd01f',
                    500: '#d9b610',
                    600: '#bb8f0a',
                    700: '#95680c',
                    800: '#7c5311',
                    900: '#6a4513',
                    950: '#3e2407',
                },
                'accessible-focus': '#facc15',
            },
        },
    },

    plugins: [forms],
};
