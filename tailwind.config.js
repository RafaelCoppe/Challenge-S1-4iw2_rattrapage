/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#004283',
        },
        secondary: {
          DEFAULT: '#3886CE',
        },
        third: {
          DEFAULT: '#FE633D',
        },
        cream: {
          DEFAULT: '#F3F7F0',
        },
      },
      width: {
        'custom-20': '20rem',
        'custom-26': '26rem',
      },
      spacing: {
        'input-width': '300px',
      }
    },
  },
  plugins: [],
}