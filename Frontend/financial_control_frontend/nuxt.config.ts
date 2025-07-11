export default defineNuxtConfig({
  css: ['@/assets/css/tailwind.css'],
  devtools: { enabled: true },

  // bom seguir a recomendação
  compatibilityDate: '2025-07-10',

  modules: ['@pinia/nuxt']
})