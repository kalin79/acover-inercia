<template>
  <div>
    <Header />
    <main>
      <slot />
    </main>
    <Footer />
    <CookieBanner />
    <WhatsAppContainer />
  </div>
</template>

<script setup>

import WhatsAppContainer from '@/js/components/Whatsapp.vue';
import Header from '@/js/components/Header.vue';
import Footer from '@/js/components/Footer.vue';
import CookieBanner from '@/js/components/CookieConsent.vue';
</script>
