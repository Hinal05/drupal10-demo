/** @type {import('tailwindcss').Config} */
// const colors = require('tailwindcss/colors');

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
    screens: {
      sm: '640px',
      // => @media (min-width: 640px) { ... }
      maxSm: { max: '639px' },
      // => @media (max-width: 639px) { ... }

      md: '768px',
      // => @media (min-width: 768px) { ... }
      maxMd: { max: '767px' },
      // => @media (max-width: 767px) { ... }

      lg: '1024px',
      // => @media (min-width: 1024px) { ... }
      maxLg: { max: '1023px' },
      // => @media (max-width: 1023px) { ... }

      lgMd: '1200px',
      // => @media (min-width: 1200px) { ... }
      maxLgMd: { max: '1199px' },
      // => @media (max-width: 1199px) { ... }

      xl: '1280px',
      // => @media (min-width: 1280px) { ... }
      maxXl: { max: '1279px' },
      // => @media (max-width: 1279px) { ... }

      '2xl': '1536px',
      // => @media (min-width: 1536px) { ... }
      max2xl: { max: '1535px' },
      // => @media (max-width: 1535px) { ... }
    },
    extend: {
      fontSize: {
        '8xl': '5.5rem', // Your custom font size
        '7xl': '3.5rem',
        '6xl': '2.75rem',
        '5xl': '2rem',
        '4xl': '1.25rem',
        '3xl': '1rem',
      },
      backgroundColor: {
        'color1': '#ffd400', // Add a new background color class 'bg-color1'
        'color2': '#00ff89',
        'color3': '#007eff',
      },
    },
    fontFamily: {
      'sans': ['Helvetica', 'Arial', 'sans-serif'],
      'serif': ['Georgia', 'serif'],
      'mono': ['Menlo', 'Monaco', 'monospace'],
      'custom': ['Verdana, Geneva, Tahoma, sans-serif']
    },
  },
  variants: {
    // extend: {
    //   textDecoration: ['hover'], // Adds hover variant to textDecoration utilities (https://tailwindcss.com/docs/hover-focus-and-other-states)
    // },
  },
  plugins: [],
}

