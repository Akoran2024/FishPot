import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#f0f7ff',
                    100: '#e0effe',
                    200: '#bae0fd',
                    300: '#7cc7fb',
                    400: '#38a9f8',
                    500: '#0e8ce4', // Ocean Blue
                    600: '#026fc7',
                    700: '#0358a1',
                    800: '#074b85',
                    900: '#0c3f6e',
                    950: '#08294a', // Deep Navy
                },
                nautical: {
                    50: '#fdfcfb',
                    100: '#f7f5f2', // Parchment
                    200: '#e3dfd6', // Sand
                    300: '#c5beb1',
                    400: '#a39b8c',
                    500: '#847c6d',
                    600: '#6a6356',
                    700: '#534d43',
                    800: '#413d35',
                    900: '#35322b',
                    950: '#1c1a17',
                },
                sea: {
                    50: '#f0fdfa',
                    100: '#ccfbf1',
                    200: '#99f6e4',
                    300: '#5eead4',
                    400: '#2dd4bf',
                    500: '#14b8a6', // Teal/Seafoam
                    600: '#0d9488',
                    700: '#0f766e',
                    800: '#115e59',
                    900: '#134e4a',
                },
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', 'Georgia', 'serif'],
            },
        },
    },

    plugins: [forms],
};
