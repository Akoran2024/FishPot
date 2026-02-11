import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // High contrast palette for accessibility
                primary: {
                    50: '#eef2ff',
                    100: '#e0e7ff',
                    200: '#c7d2fe',
                    300: '#a5b4fc',
                    400: '#818cf8',
                    500: '#6366f1',
                    600: '#4f46e5',
                    700: '#4338ca', // Good contrast on white
                    800: '#3730a3',
                    900: '#312e81',
                    950: '#1e1b4b',
                },
                accessible: {
                    text: '#0f172a', // Slate 900 for main text
                    muted: '#334155', // Slate 700 for secondary text (minimum 4.5:1)
                    border: '#94a3b8', // Slate 400 for borders (visible)
                    focus: '#f59e0b', // Amber 500 for clear focus rings
                }
            }
        },
    },

    plugins: [forms],
};
