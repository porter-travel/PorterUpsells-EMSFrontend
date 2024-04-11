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
        colors: {
            'gold': '#BB9C7C',
            'blue': '#051532',
            'black' : '#000000',
            'teal' : '#95F2F2',
            'white' : '#FFFFFF',
            'grey': '#EFEFEF'
        },
        extend: {
            fontFamily: {
                sans: ['open-sans', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
