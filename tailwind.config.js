const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './app/Models/*.php',
        './resources/views/**/*.blade.php',
        './resources/ts/**/*.tsx',
    ],

    theme: {
        container: {
            center: true,
            padding: {
                DEFAULT: '1rem',
                sm: '2rem',
                lg: '4rem',
                xl: '5rem',
                '2xl': '6rem',
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
