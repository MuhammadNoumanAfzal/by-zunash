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
          50: '#F5F2F0',
          100: '#E6E1DC',
          200: '#C8BEB6',
          700: '#3D281E',
          800: '#2F1E16',
          900: '#24160F',
          950: '#150C08',
          DEFAULT: '#24160F',
        },
        chocolate: {
          100: '#F2E8E4',
          300: '#B68878',
          500: '#754533',
          700: '#4A2C20',
          800: '#382118',
          900: '#2A1811',
          DEFAULT: '#4A2C20',
        },
        tan: {
          50: '#FAF4EF',
          100: '#F3E5D9',
          200: '#E5CBB5',
          300: '#D5AE8F',
          400: '#BF8F66',
          500: '#A87548',
          600: '#8E5F36',
          700: '#734B28',
          800: '#5A391D',
          DEFAULT: '#A87548',
        },
        gold: {
          50: '#FAF7F0',
          100: '#F3ECD9',
          200: '#E4D5B1',
          300: '#D5BC8A',
          400: '#C5A16B',
          500: '#B38B4F',
          600: '#94703B',
          700: '#74542B',
          DEFAULT: '#C5A16B',
        },
        ivory: {
          50: '#FDFBF7',
          DEFAULT: '#F8F4ED',
          100: '#F8F4ED',
          200: '#EFE9DF',
          300: '#E2D9CB',
          400: '#D3C7B5',
        },
        muted: {
          light: '#A3998F',
          DEFAULT: '#766D64',
          dark: '#524B43',
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
