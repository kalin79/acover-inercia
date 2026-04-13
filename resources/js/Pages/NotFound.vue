<!-- js/pages/NotFound.vue -->
<template>
  <div class="not-found">
    <h1>404</h1>
    <p>Página no encontrada</p>
    <Link :href="$route('/')">Volver al inicio</Link>
  </div>
</template>
<script setup>
import { Link } from '@inertiajs/vue3'

</script>
<style scoped>
.not-found {
  text-align: center;
  padding: 4rem 1rem;
  height: 100vh;
}
</style>
