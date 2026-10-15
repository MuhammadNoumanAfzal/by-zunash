/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./app/Http/Controllers/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        espresso: {
          50: '#F5F5F5',
          100: '#E5E5E5',
          200: '#CCCCCC',
          300: '#999999',
          400: '#666666',
          700: '#262626',
          800: '#18181A',
          900: '#121212',
          950: '#0A0A0A',
          DEFAULT: '#121212',
        },
        chocolate: {
          100: '#F4EFEA',
          300: '#C49A82',
          500: '#8E583C',
          700: '#26201C',
          800: '#1C1714',
          900: '#120E0C',
          DEFAULT: '#1C1714',
        },
        tan: {
          50: '#FDF8F3',
          100: '#F7ECE1',
          200: '#ECCEB8',
          300: '#DEAC8B',
          400: '#C9885C',
          500: '#B07D4E',
          600: '#976239',
          700: '#7A4B27',
          800: '#5E361A',
          DEFAULT: '#B07D4E',
        },
        gold: {
          50: '#FBF9F2',
          100: '#F5F0DF',
          200: '#E9DDBC',
          300: '#DAC694',
          400: '#C5A16B',
          500: '#B38D4F',
          600: '#947137',
          700: '#735425',
          DEFAULT: '#C5A16B',
        },
        ivory: {
          50: '#FDFAF6',
          DEFAULT: '#FAF9F6',
          100: '#FAF9F6',
          200: '#F2EFE8',
          300: '#E6E1D5',
          400: '#D4CDC0',
        },
        muted: {
          light: '#A19E98',
          DEFAULT: '#73706A',
          dark: '#474540',
        },
      },
      fontFamily: {
        serif: ['"Playfair Display"', 'Georgia', 'Cambria', 'serif'],
        sans: ['"Plus Jakarta Sans"', 'Inter', '-apple-system', 'BlinkMacSystemFont', 'sans-serif'],
      },
      letterSpacing: {
        widest: '.2em',
        ultra: '.28em',
      },
      boxShadow: {
        'luxury': '0 20px 40px -15px rgba(36, 22, 15, 0.08)',
        'luxury-hover': '0 25px 50px -12px rgba(36, 22, 15, 0.16)',
        'gold-glow': '0 0 25px -5px rgba(197, 161, 107, 0.25)',
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-out forwards',
        'slide-up': 'slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { opacity: '0', transform: 'translateY(20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
      },
    },
  },
  plugins: [],
}
