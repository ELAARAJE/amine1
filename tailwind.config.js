import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                playfair: ['"Playfair Display"', 'Georgia', 'serif'],
                lato: ['Lato', 'system-ui', 'sans-serif'],
            },
            colors: {
                birlik: {
                    black:       '#0d0d0d',
                    cream:       '#f5f0e8',
                    'cream-dark':'#ede8db',
                    gold:        '#b8972a',
                    'gold-light':'#d4af37',
                },
            },
            letterSpacing: {
                widest2: '0.25em',
                widest3: '0.35em',
            },
        },
    },

    plugins: [forms],
};
