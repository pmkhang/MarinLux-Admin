/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            screens: {
                dt: { max: "1400px" },
                tl: { max: "1024px" },
                mb: { max: "768px" },
            },
        },
    },
    plugins: [],
};
