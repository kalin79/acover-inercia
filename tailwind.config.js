/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./app/Filament/**/*.php",           // Importante para Filament
    "./vendor/filament/**/*.blade.php",  // Estilos de Filament
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}