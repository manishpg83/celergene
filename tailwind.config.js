/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.vue',
      // Add any other paths where you use Tailwind classes
    ],
    theme: {
      extend: {
        colors: {
          'custom-black': '#27282A',
          'custom-black-table': '#1E1F20',
          'custom-white': '#F5F5F5',
          'custom-bg': '#F8F8F8',
        },
        boxShadow: {
            'custom-card': '0 .1875rem .75rem 0 rgba(47, 43, 61, .14)',
        }
      },
    },
    plugins: [],
  }
