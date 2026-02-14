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
                primary: { // Deep, classic sea blues/greens
                    50: '#e0f2f7',   // Lightest Sky/Water
                    100: '#b3e5fc',  // Light Blue Sky
                    200: '#81d4fa',  // Muted Sky Blue
                    300: '#4fc3f7',  // Clear Water
                    400: '#29b6f6',  // Ocean Surface
                    500: '#039be5',  // Main Deep Ocean Blue
                    600: '#0288d1',  // Darker Ocean
                    700: '#0277bd',  // Deep Sea
                    800: '#01579b',  // Abyss Blue
                    900: '#013a6e',  // Midnight Ocean
                    950: '#002855',  // Deepest Midnight Blue
                },
                secondary: { // Weathered Wood / Sand / Off-whites
                    50: '#f9f5f0',   // Creamy Off-white (Parchment)
                    100: '#f0ede8',  // Light Linen
                    200: '#e0dcd7',  // Muted Sand
                    300: '#d1cdc7',  // Aged Stone
                    400: '#c2bcb6',  // Light Wood Grain
                    500: '#b3ad9f',  // Main Weathered Wood/Stone
                    600: '#9d988a',  // Darker Wood/Stone
                    700: '#878275',  // Deep Earthy Grey
                    800: '#716c60',  // Dark Wood
                    900: '#5c574e',  // Rich Earth Brown
                    950: '#3e3a33',  // Darkest Earthy Tone
                },
                accent: { // Muted Reds / Brass / Gold (for highlights, classic feel)
                    50: '#fef3f2',
                    100: '#fee2e2',
                    200: '#fecaca',
                    300: '#fca5a5',
                    400: '#ef4444', // Classic Buoy Red
                    500: '#dc2626', // Main Accent Red
                    600: '#b91c1c',
                    700: '#991b1b',
                    800: '#7f1d1d',
                    900: '#641d26',
                    950: '#450a0a',
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
