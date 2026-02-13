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
                    50: '#f2f7f9',
                    100: '#e1ecf2',
                    200: '#c7dce8',
                    300: '#9dbfd4',
                    400: '#6c9bb8',
                    500: '#4e7d9c',
                    600: '#406683',
                    700: '#36536b',
                    800: '#30475a',
                    900: '#2b3d4d',
                    950: '#1c2833', // Deep Oceanic
                },
                accent: {
                    50: '#faf8f2',
                    100: '#f3ece1',
                    200: '#e6d8c0',
                    300: '#d4ba92',
                    400: '#c3a16d',
                    500: '#b68c52', // Sandy/Earth
                    600: '#a67746',
                    700: '#8a5e3b',
                    800: '#714d34',
                    900: '#5c3f2d',
                    950: '#311f16',
                },
                'volcanic': {
                    DEFAULT: '#1a1a1a',
                    light: '#2d2d2d',
                },
                'accessible-focus': '#b68c52',
            },
        },
    },

    plugins: [forms],
};
