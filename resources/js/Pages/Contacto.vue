<template>
  <section>
    <!-- <Carousel :banners="homeData" /> -->

    <div class="pageContactoContainer">
      <div class="containerFluid">
        <div class="gridLayout">
          <div>
            <h2>Conecta con nosotros</h2>
            <p>
              Completa el formulario de contacto, escríbenos directamente a nuestro correo...
            </p>

            <form @submit.prevent="onSubmit">
              <div class="rowItem">
                <input v-model="nombres" type="text" placeholder="Nombres y Apellidos" />
              </div>

              <div class="rowItem">
                <input v-model="email" type="email" placeholder="Correo electrónico" />
              </div>

              <div class="rowItem">
                <input v-model="celular" type="tel" placeholder="Nro. de celular" />
              </div>

              <div class="rowItem">
                <input v-model="asunto" type="text" placeholder="Asunto" />
              </div>

              <div class="rowItem">
                <textarea v-model="mensaje" placeholder="Escribe aquí tu mensaje...."></textarea>
              </div>

              <!-- Checkbox customizado -->
              <div class="rowItem2">
                <label class="custom-checkbox" :class="{ checked: checked }">
                  <input
                    type="checkbox"
                    v-model="checked"
                    class="hidden-input"
                  />
                  <span class="checkmark"></span>
                  <span class="label-text">
                    Estoy de acuerdo con los 
                    <a href="/terminos-y-condiciones" target="_blank">Términos y Condiciones</a> 
                    y la 
                    <a href="/politica-de-privacidad" target="_blank">Política de Privacidad</a>.
                  </span>
                </label>
              </div>

              <!-- Mensaje de error general -->
              <div v-if="mensajeError" class="rowItem2">
                <span class="DescripcionMediano2 txtRosado">{{ mensajeError }}</span>
              </div>

              <div v-if="mensajeExito" class="rowItem2">
                <span class="DescripcionMediano2 txtRosado">{{ mensajeExito }}</span>
              </div>

              <div class="rowItem2">
                <button type="submit" class="btnEnviar" :disabled="isSubmitting">
                  {{ isSubmitting ? 'ENVIANDO...' : 'ENVIAR' }}
                </button>
              </div>
            </form>
          </div>
          <div>
            <h2>Vive la experiencia en nuestras tiendas</h2>
                    <p>
                        Te invitamos a visitarnos y recibir atención especializada, disfrutando de la experiencia completa de nuestros productos.
                    </p>
                    <div class="listInfoContacto">
                        <div class="rowLocal">
                            <div class="iconContainer">
                                <img :src="icon1" alt="" />
                            </div>
                            <div class="infoContainer">
                                <h3>Galería Barrio Chino</h3>
                                <p>
                                    Jr. Paruro 860 / Jr. Ucayali 724, Cercado de Lima
                                    Ref. Calle Capón cerca al Mcdo. Central
                                    Stands 1077, 1102, 1113 y 1080
                                </p>
                                <a href="https://maps.app.goo.gl/dLrXAv4xrMHN1Kpt6" target="_blank" class="btnMap">¿CÓMO LLEGAR?</a>
                            </div>
                        </div>
                        <div class="rowLocal">
                            <div class="iconContainer">
                                <img :src="icon1" alt="" />
                            </div>
                            <div class="infoContainer">
                                <h3>Jesús María</h3>
                                <p>
                                    Av. Arnaldo Márquez 1082
                                    Ref. Al costado de la comisaria del distrito de Jesús María
                                </p>
                                <a href="https://maps.app.goo.gl/s7no1vyU1nFAckDa8" target="_blank" class="btnMap">¿CÓMO LLEGAR?</a>
                            </div>
                        </div>
                        <div class="rowLocal">
                            <div class="iconContainer">
                                <img :src="icon2" alt="" />
                            </div>
                            <div class="infoContainer">
                                <h3>Horarios de atención</h3>
                                <p>
                                    De lunes a sábados 11:00 am - 06:00 pm 
                                    Domingos de 10:30 am - 04:00 pm
                                    Otros horarios previa coordinación 
                                </p>
                            </div>
                        </div>
                        <div class="rowLocal">
                            <div class="iconContainer">
                                <img :src="icon3" alt="" />
                            </div>
                            <div class="infoContainer">
                                <h3>Correo electrónico</h3>
                                <a href="mailto:branasac@gmail.com">branasac@gmail.com</a>
                            </div>
                        </div>

                        <div class="rowLocal">
                            <div class="iconContainer">
                                <img :src="icon4" alt="" />
                            </div>
                            <div class="infoContainer">
                                <h3>Whatsapp</h3>
                                <p>+51 955 128 016</p>
                            </div>
                        </div>

                        <div class="redesContainer">
                            <a href="https://www.facebook.com/search/top?q=brana%20per%C3%BA" target="_blank">
                                <img :src="redes1" alt="" />
                            </a>
                            <a href="https://www.instagram.com/brana.peru/" target="_blank">
                                <img :src="redes2" alt="" />
                            </a>
                            <a href="https://www.tiktok.com/@brana.peru?lang=es-419" target="_blank">
                                <img :src="redes3" alt="" />
                            </a>
                        </div>

                    </div>
          </div>
          <!-- Resto de tu contenido (tiendas, horarios, etc.) -->
          <!-- ... -->
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
// import Carousel from '@/js/components/BannerMini.vue'
import { useForm, useField } from 'vee-validate'
import { toFormValidator } from "@vee-validate/zod"
import * as z from 'zod'
import { ref, watch, onMounted } from 'vue'
import axios from 'axios';
const checked = ref(false)
const icon1 = '/images/frontend/local.svg';
const icon2 = '/images/frontend/reloj.svg';
const icon3 = '/images/frontend/email2.svg';
const icon4 = '/images/frontend/wha.svg';
const redes1 = '/images/frontend/ff.svg';
const redes2 = '/images/frontend/ii.svg';
const redes3 = '/images/frontend/tt.svg';
const homeData = ref(
    {
    "data": {
            "banners" : [
                {
                    "titulo": "Mente y cuerpo en equilibrio natural",
                    "descripcion": null,
                    "poster": "/images/frontend/bcontact.webp",
                    "poster_mobile": "/images/frontend/bcontact.webp",
                    "button": null,
                    "link": "/contacto",
                    "abrir_otra_ventana": false,
                    "position": 1,
                    "active": true
                }
            ]
        },
    }
);
onMounted(() => {
  document.title = 'Contacto | Mi Tienda';
  
  // Actualizar descripción
  let description = document.querySelector('meta[name="description"]');
  if (!description) {
    description = document.createElement('meta');
    description.name = 'description';
    document.head.appendChild(description);
  }
  description.content = 'Bienvenido a la seccion de Contancto';
});
// ========================
// SCHEMA DE VALIDACIÓN (Zod)
// ========================
const schema = z.object({
  nombres: z.string()
    .min(1, "El nombre es obligatorio")
    .min(3, "El nombre debe tener al menos 3 caracteres")
    .max(60, "El nombre es muy largo")
    .regex(/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/, "El nombre solo debe contener letras y espacios"),

  email: z.string()
    .min(1, "El correo electrónico es obligatorio")
    .email("Ingresa un correo electrónico válido"),

  celular: z.string()
    .min(1, "El número de celular es obligatorio")
    .regex(/^9\d{8}$/, "El celular debe tener 9 dígitos y comenzar con 9"),

  asunto: z.string()
    .min(1, "El asunto es obligatorio")
    .max(100, "El asunto es muy largo"),

  mensaje: z.string()
    .min(1, "El mensaje es obligatorio")
    .min(10, "El mensaje debe tener al menos 10 caracteres"),

  checked: z.boolean()
    .refine(val => val === true, {
      message: "Debes aceptar los Términos y Condiciones"
    })
})

// ========================
// VeeValidate
// ========================
const { handleSubmit, isSubmitting } = useForm({
  validationSchema: toFormValidator(schema),
})

// Campos controlados
const { value: nombres } = useField('nombres')
const { value: email }   = useField('email')
const { value: celular } = useField('celular')
const { value: asunto }  = useField('asunto')
const { value: mensaje } = useField('mensaje')
const { value: checkedField } = useField('checked')   // importante para el checkbox

// Sincronizamos el ref del checkbox con vee-validate
watch(checked, (newVal) => {
  checkedField.value = newVal
})

const mensajeError = ref("")
const mensajeExito = ref("")

const onSubmit = handleSubmit(
  async (values) => {
    mensajeError.value = ""
    mensajeExito.value = ""
    console.log("Formulario enviado correctamente:", values);
    // Aquí haces la llamada a tu API
    // const _URL = `http://127.0.0.1:8000/api/v1/contactanos/store`;
    const _URL = `https://branaperu.com/api/v1/contactanos/store`;
      const response = await axios.post(_URL, {
        nombre_apellidos: values.nombres,
        correo: values.email,
        nro_celular: values.celular,
        asunto: values.asunto,
        mensaje: values.mensaje,
        tyc: true
      }, {
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "Authorization-secret": import.meta.env.VITE_AUTHORIZATION_FORM
        }
      })

      console.log(response);

      // Si todo sale bien
      mensajeExito.value = "¡Mensaje enviado correctamente! Nos pondremos en contacto pronto."
      
      // Opcional: Resetear el formulario
      // resetForm()

      console.log("Respuesta de la API:", response.data)

  },
  (errors) => {
    mensajeError.value = "Por favor corrige los errores del formulario."
    console.log("Errores de validación:", errors)
    console.log(errors);
    if (errors.errors.email) {
        mensajeError.value = 'Email campo obligatorio';
    } else if (errors.errors.asunto) {
        mensajeError.value = 'Asunto campo obligatorio';
    } else if (errors.errors.nombres){
        mensajeError.value = 'Nombres campo obligatorio';
    } else if (errors.errors.celular){
        mensajeError.value = 'Celular campo obligatorio';
    } else if (errors.errors.checked){
        mensajeError.value = 'Debe seleccionar los T&C';
    } else if (errors.errors.mensaje){
        mensajeError.value = 'Mensaje campo obligatorio';
    }
     
    else {
        mensajeError.value = "Por favor revisa los campos antes de continuar.";
    }
  }
)
</script>