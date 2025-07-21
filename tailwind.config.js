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
            },
            animation:{
                 'fade-in': 'fadeIn 0.5s ease-in-out',
                'slide-down': 'slideDown 0.5s ease-out',
                'fade-in-up': 'fadeInUp 0.5s ease-out',
            }
        },
    },

    plugins: [forms],
};
