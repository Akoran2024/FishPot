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
                primary: { // Deep Ocean Blues & Greens
                    50: '#e0f7fa',   // Lightest Aqua
                    100: '#b2ebf2',  // Light Aqua
                    200: '#80deea',  // Aqua
                    300: '#4dd0e1',  // Vibrant Aqua
                    400: '#26c6da',  // Deep Aqua
                    500: '#00bcd4',  // Ocean Teal - Main
                    600: '#00acc1',  // Darker Ocean Teal
                    700: '#0097a7',  // Deep Teal
                    800: '#00838f',  // Very Deep Teal
                    900: '#006064',  // Darkest Ocean
                    950: '#003a3d',  // Abyss
                },
                secondary: { // Sandy Shores & Driftwood/Netting
                    50: '#fafafa',   // Near White Sand
                    100: '#f5f5f5',  // Light Sand
                    200: '#eeeeee',  // Pale Driftwood
                    300: '#e0e0e0',  // Light Driftwood
                    400: '#bdbdbd',  // Greyed Wood
                    500: '#9e9e9e',  // Main Driftwood/Netting Grey
                    600: '#757575',  // Darker Netting
                    700: '#616161',  // Stone Grey
                    800: '#424242',  // Dark Stone
                    900: '#212121',  // Deep Charcoal
                    950: '#000000',  // Black
                },
                accent: { // Buoy Red / Sunset Orange
                    50: '#fff3e0',
                    100: '#ffe0b2',
                    200: '#ffcc80',
                    300: '#ffb74d',
                    400: '#ffa726',
                    500: '#ff9800',
                    600: '#fb8c00',
                    700: '#f57c00',
                    800: '#ef6c00',
                    900: '#e65100',
                    950: '#bf360c',
                },
                gold: { // Aged brass/gold for metallic accents
                    DEFAULT: '#d4af37',
                    light: '#e6c35c',
                    dark: '#a2882a',
                }
            },
        },
    },

    plugins: [forms],
};
