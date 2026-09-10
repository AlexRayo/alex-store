/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './inc/**/*.php',
    './template-parts/**/*.php',
    './woocommerce/**/*.php',
    './src/js/**/*.js'
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: 'var(--color-primary, #0f172a)',
          dark: 'var(--color-primary-dark, #020617)',
          light: 'var(--color-primary-light, #f1f5f9)',
          50: '#f8fafc',
          100: '#f1f5f9',
          200: '#e2e8f0',
          300: '#cbd5e1',
          400: '#94a3b8',
          500: '#64748b',
          600: '#475569',
          700: '#334155',
          800: '#1e293b',
          900: 'var(--color-primary, #0f172a)',
          950: 'var(--color-primary-dark, #020617)',
        },
        cta: {
          DEFAULT: 'var(--color-cta, #2563eb)',
          hover: 'var(--color-cta-hover, #1d4ed8)',
          light: 'var(--color-cta-light, #eff6ff)',
        },
        dark: {
          DEFAULT: '#0a0a0a',
          card: '#121212',
          surface: '#18181b',
          muted: '#52525b',
        },
        neutral: {
          50: '#f9fafb',
          100: '#f3f4f6',
          200: '#e5e7eb',
          300: '#d1d5db',
          400: '#9ca3af',
          500: '#6b7280',
          600: '#4b5563',
          700: '#374151',
          800: '#1f2937',
          900: '#111827',
          950: '#030712',
          bg: '#f9fafb',
          surface: '#ffffff',
          border: '#e5e7eb',
          subtle: '#6b7280',
          muted: '#9ca3af',
          light: '#f3f4f6',
          dark: '#111827',
        },
        accent: {
          DEFAULT: '#18181b',
          dark: '#09090b',
          light: '#f4f4f5',
        },
        secondary: {
          DEFAULT: '#3f3f46',
          dark: '#27272a',
          light: '#e4e4e7',
        }
      },
      fontFamily: {
        sans: ['var(--font-sans, Inter)', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
        heading: ['var(--font-sans, Inter)', 'sans-serif'],
      },
      borderRadius: {
        'card': '16px',
        'badge': '6px',
        'button': '10px',
        'xl2': '18px',
        'xl3': '24px',
      },
      boxShadow: {
        'subtle': '0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px -1px rgba(0, 0, 0, 0.04)',
        'card': '0 2px 8px -2px rgba(0, 0, 0, 0.05), 0 1px 4px -1px rgba(0, 0, 0, 0.03)',
        'card-hover': '0 12px 24px -6px rgba(0, 0, 0, 0.09), 0 4px 8px -2px rgba(0, 0, 0, 0.03)',
        'cta': '0 4px 14px 0 rgba(37, 99, 235, 0.35)',
        'cta-hover': '0 6px 20px rgba(37, 99, 235, 0.45)',
        'drawer': '-10px 0 40px rgba(0, 0, 0, 0.15)',
        'dropdown': '0 10px 30px rgba(0, 0, 0, 0.08)',
        'modal': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms')({
      strategy: 'class',
    }),
    require('@tailwindcss/typography'),
  ],
}
