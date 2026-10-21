/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "../application/views/**/*.php",
    "./components/**/*.{js,jsx,ts,tsx}",
    "./src/**/*.{js,jsx,ts,tsx}",
    "./*.{js,jsx,html}"
  ],
  theme: {
    extend: {
      colors: {
        'sport-red': {
          DEFAULT: '#E5252A',
          hover: '#c41c21',
          light: '#fef2f2',
          50: '#fef2f2',
          100: '#fee2e2',
          500: '#E5252A',
          600: '#c41c21',
          700: '#991b1b',
        },
        'charcoal': {
          DEFAULT: '#1E2229',
          light: '#2D333D',
          dark: '#14171C',
        },
        'slate-neutral': {
          light: '#F8FAFC',
          dark: '#0F172A',
        }
      },
      fontFamily: {
        heading: ['Montserrat', 'Arial Black', 'sans-serif'],
        sans: ['Inter', 'system-ui', 'sans-serif'],
      }
    },
  },
  plugins: [],
}
