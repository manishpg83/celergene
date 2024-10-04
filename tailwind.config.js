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
        },
      },
    },
    plugins: [],
  }
