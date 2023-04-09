module.exports = {
  mode: 'jit',                           //ADD THIS LINE
  purge: [                               //CONFIGURE CORRECTLY
    '**/*.php',
    '*.php',
  ],
  darkMode: false,
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}