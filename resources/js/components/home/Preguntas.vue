<template>
<div class="preguntasHomeSeccion">
    <div class="containerFluid">
        <div class="gridLayout">
            <div>
                <img :src="img1" alt="" />
            </div>
            <div>
                <div class="headerPreguntasContainer">
                    <h2>
                        ¿POR QUÉ ELEGIR <br />
                        NUESTROS LOCKERS?
                    </h2>
                    <p>
                        Diseñados para resistir el uso diario más exigente en entornos <br />
                        industriales y corporativos.
                    </p>
                </div>

                <div class="bodyPreguntasContainer">
                    <div v-for="(tipo, index) in faqs" :key="index" class="faqItem">
                        <button @click="toggle(index)">
                            <div class="btnLeft">
                                <span class="numeroAccordion">0{{index + 1}}.</span>
                                <span class="titularAccordion">
                                {{ tipo.titulo }}
                                </span>
                            </div>
                            <div class="iconFaq">
                                <img :src="iconMas" alt="" v-if="openIndex === index" />
                                <img :src="iconMenos" alt="" v-else/>
                            </div>
                        </button>
                        <div class="faqBody" v-if="openIndex === index">
                            {{ tipo.descripcion }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script setup>
import { ref, reactive } from 'vue'

const iconMas = '/images/abrir.png'
const iconMenos = '/images/cerrar.png'

const img1 = '/images/info.webp'

const faqs = reactive([
    {
        titulo: "Máxima seguridad",
        open: false,
        descripcion: `Sistema de cierre reforzado compatible con múltiples tipos de cerraduras, con sistemas de cierre confiables que garantizan la protección de pertenencias personales en todo momento.`
    },
    {
        titulo: "Alta durabilidad",
        open: false,
        descripcion: `Sistema de cierre reforzado compatible con múltiples tipos de cerraduras, con sistemas de cierre confiables que garantizan la protección de pertenencias personales en todo momento.`
    },
    {
        titulo: "Variedad de tamaños y configuraciones",
        open: false,
        descripcion: `Sistema de cierre reforzado compatible con múltiples tipos de cerraduras, con sistemas de cierre confiables que garantizan la protección de pertenencias personales en todo momento.`
    },
    {
        titulo: "Entrega puntual y atención personalizada",
        open: false,
        descripcion: `Sistema de cierre reforzado compatible con múltiples tipos de cerraduras, con sistemas de cierre confiables que garantizan la protección de pertenencias personales en todo momento.`
    },
    {
        titulo: "Fácil mantenimiento",
        open: false,
        descripcion: `Sistema de cierre reforzado compatible con múltiples tipos de cerraduras, con sistemas de cierre confiables que garantizan la protección de pertenencias personales en todo momento.`
    },
  
]);
// Guardamos cuál índice está abierto (-1 = ninguno abierto)
const openIndex = ref(0);

const toggle = (index) => {
  // Si ya está abierto, lo cerramos
  if (openIndex.value === index) {
    openIndex.value = -1
  } else {
    // Si abrimos uno nuevo, cerramos los demás
    openIndex.value = index
  }
}

</script>
