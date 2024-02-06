/** @type {import('tailwindcss').Config} */

module.exports = {
  content: ['./templates/**/*.twig'],
  theme: {
    container: {
      center: true,
      screens: {
        sm: '100%',
        md: '100%',
        lg: '100%',
        xl: '1216px',
        '2xl': '1536px',
      },
    },
    extend: {
      fontSize: {
        '8xl': '5.5rem', // Your custom font size
        '7xl': '3.5rem',
        '6xl': '2.75rem',
        '5xl': '2rem',
        '4xl': '1.25rem',
        '3xl': '1rem',
      }
    },
    backgroundColor: {
      'color1': '#ffd400', // Add a new background color class 'bg-color1'
      'color2': '#00ff89',
      'color3': '#007eff',
    },
  },
  plugins: [],
}

