import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'

export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],

  darkMode: 'class',

  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
        display: ['"Plus Jakarta Sans"', 'Inter', ...defaultTheme.fontFamily.sans],
      },
      boxShadow: {
        'brand-glow': '0 0 40px -10px rgba(202, 138, 4, 0.35)',
        'panel': '0 4px 24px -4px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(15, 23, 42, 0.04)',
        'panel-dark': '0 4px 24px -4px rgba(0, 0, 0, 0.45), 0 0 0 1px rgba(255, 255, 255, 0.06)',
        'glass-dark': '0 0 0 1px rgba(202, 138, 4, 0.18), 0 24px 80px -12px rgba(0, 0, 0, 0.65), 0 0 100px -40px rgba(202, 138, 4, 0.2)',
      },
      colors: {
        primary: {
          light: '#94a3a3',
          DEFAULT: '#475d5b', // Sleek dark teal-gray
          dark: '#2f3f3d',
        },
        background: {
          light: '#f7f8f9',
          dark: '#121212',
        },
        surface: {
          light: '#ffffff',
          dark: '#1f1f1f',
        },
        // === SIENNA AMBER THEME COLOR ADDED HERE ===
        sienna: {
          DEFAULT: '#CA8A04', // Sienna Amber: Primary color
          dark: '#A16207',    // Darker shade for hover states
          light: '#FDE68A',   // Lightest shade for backgrounds (e.g., hover:bg-sienna-light/50)
        },
        brand: {
          DEFAULT: '#CA8A04',
          dark: '#A16207',
        },
        // ==========================================
      },
    },
  },

  plugins: [forms, typography],
}