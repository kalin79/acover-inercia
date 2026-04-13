<template>
    <section>
        <!-- <Carousel :banners="homeData" /> -->
        <div class="pageReclamacionesContainer">
            <div class="fondo">
                <img :src="img1" alt="">
            </div>
            <div class="fondo2">
                <img :src="img2" alt="">
            </div>
            <div class="fondo3">
                <img :src="img3" alt="">
            </div>
            <div class="fondo4">
                <img :src="img4" alt="">
            </div>
            <div class="fondo5">
                <img :src="img5" alt="">
            </div>
            <div class="containerFluid">
                <div class="headerContainer">
                    <div>
                        <div class="itemContainer">
                            <h2>Razón Social: </h2>
                            <h3>BRANA PERU SAC</h3>
                        </div>
                        <div class="itemContainer">
                            <h2>RUC: </h2>
                            <h3>20603365837</h3>
                        </div>
                        <div class="itemContainer">
                            <h2>Dirección: </h2>
                            <h3>Av. Arnaldo Márquez 1082</h3>
                        </div>
                    </div>
                    <div>
                        <p>
                            Completa el formulario y nuestro equipo revisará tu solicitud con atención, transparencia y el compromiso de ofrecerte una respuesta oportuna. Tu opinión nos ayuda a seguir creando experiencias más armoniosas para ti.
                        </p>
                    </div>
                </div>
                <div class="bodyContainer">
                    <form @submit.prevent="onSubmit">
                        <div class="etapaContainer">
                            1. Identificación del consumidor reclamante
                        </div>
                        <div class="inputsContainer">
                            <div class="rowItem">
                                <input v-model="nombres" type="text" placeholder="Nombres" />
                            </div>
                            <div class="rowItem">
                                <input v-model="apellidos" type="text" placeholder="Apellidos" />
                            </div>
                            <div class="rowItem">
                                <div class="select-wrapper">
                                    <select 
                                        v-model="_tipo_documento"
                                        id="documento"
                                        class="custom-select"
                                    >
                                        <option value="" disabled>Tipo de documento</option>
                                        <option 
                                            v-for="(doc, index) in documentos" 
                                            :key="index" 
                                            :value="doc.valor"
                                        >
                                            {{ doc.nombre }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="rowItem">
                                <input v-model="documento" type="text" placeholder="Número de documento" />
                            </div>
                            <div class="rowItem">
                                <input v-model="celular" type="text" placeholder="Nro. de celular:" />
                            </div>
                            <div class="rowItem">
                                <input v-model="email" type="text" placeholder="Correo electrónico" />
                            </div>
                        </div>
                        <div class="etapaContainer">
                            2. Identificación del bien contratado
                        </div>
                        <div class="inputsContainer">
                            <div class="rowItem">
                                <input v-model="producto" type="text" placeholder="Producto" />
                            </div>
                            <div class="rowItem">
                                <input v-model="pedido" type="text" placeholder="Nro. de pedido" />
                            </div>
                        </div>
                        <div class="inputsContainer2">
                            <div class="rowItem">
                               <textarea v-model="descripcion" placeholder="Descripción"></textarea>
                            </div>
                        </div>
                        <div class="etapaContainer">
                            3. Detalle de la reclamación y pedido del consumidor
                        </div>
                        <div class="inputsContainer">
                            <div class="rowItem">
                                <div class="select-wrapper">
                                    <select 
                                        v-model="_tipo"
                                        id="tipo"
                                        class="custom-select"
                                    >
                                        <option value="" disabled>Tipo</option>
                                        <option 
                                            v-for="(tip, index) in tipos" 
                                            :key="index" 
                                            :value="tip.valor"
                                        >
                                            {{ tip.nombre }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="inputsContainer2">
                            <div class="rowItem">
                               <textarea v-model="descripcionTipo" placeholder="Detalle"></textarea>
                            </div>
                        </div>
                        <div class="inputsContainer2">
                            <div class="rowItem">
                               <textarea v-model="descripcionPedido" placeholder="Pedido (¿Qué es lo que solicitaste?)"></textarea>
                            </div>
                        </div>
                        <div class="inputsContainer2">
                            <p>* RECLAMO: Disconformidad relacionada a los productos o servicios</p>
                            <p>** QUEJA: Disconformidad no relacionada a los productos o servicios; o, malestar o descontento respecto a la atención al público.</p>
                            <p>La formulación del reclamo no impide acudir a otras vías de solución de controversias ni es requisito previo para interponer una denuncia ante el INDECOPI.</p>
                            <p>El proveedor debe dar respuesta al reclamo o queja en un plazo no mayor a quince (15) días hábiles, el cual es improrrogable.</p>
                        </div>
                        <div class="inputsContainer3 separate">
                            <div class="rowItem">
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
                        </div>
                        <div class="inputsContainer2">
                            <!-- Mensaje de error general -->
                            <div v-if="mensajeError" class="rowItem2 errorContainer">
                                <span class="DescripcionMediano2">{{ mensajeError }}</span>
                            </div>

                            <div v-if="mensajeExito" class="rowItem2 exitoContainer">
                                <span class="DescripcionMediano2">{{ mensajeExito }}</span>
                            </div>
                        </div>
                        <div class="inputsContainer3">
                            <div class="rowItem">
                                <button type="submit" class="btnEnviar" :disabled="isSubmitting">
                                {{ isSubmitting ? 'ENVIANDO...' : 'ENVIAR' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
// import Carousel from '@/js/components/BannerMini.vue';
import { useForm, useField } from 'vee-validate'
import { toFormValidator } from "@vee-validate/zod"
import * as z from 'zod'
import { ref, watch, onMounted } from 'vue'
import axios from 'axios';
const img1 = '/images/frontend/planta1.webp'
const img2 = '/images/frontend/planta22.webp'
const img3 = '/images/frontend/planta2.webp'
const img4 = '/images/frontend/planta4.webp'
const img5 = '/images/frontend/planta5.webp'
const checked = ref(false);
const _tipo_documento = ref('');
const documentos = ref([
    {
        'valor': '1',
        'nombre': 'DNI'
    },
    {
        'valor': '2',
        'nombre': 'CE'
    }
]);
const _tipo = ref('');
const tipos = ref([
    {
        'valor': 'reclamo',
        'nombre': 'Reclamo'
    },
    {
        'valor': 'queja',
        'nombre': 'Queja'
    }
]);
const homeData = ref(
    {
    "data": {
            "banners" : [
                {
                    "titulo": "Mente y cuerpo en equilibrio natural",
                    "descripcion": null,
                    "poster": "/images/frontend/breclamaciones.webp",
                    "poster_mobile": "/images/frontend/breclamaciones.webp",
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

    apellidos: z.string()
        .min(1, "El apellido es obligatorio")
        .min(3, "El apellido debe tener al menos 3 caracteres")
        .max(60, "El apellido es muy largo")
        .regex(/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/, "El apellido solo debe contener letras y espacios"),
    
    tipo_documento: z.string().min(1, "Debes seleccionar un tipo de documento")
        .refine((val) => documentos.value.some(doc => doc.valor === val), {
            message: "Tipo de documento no válido",
        }),

    documento: z.string()
        .min(1, "El número de documento es obligatorio")
        .regex(/^\d+$/, "Solo se permiten números")                    // solo dígitos (0-9)
        .min(8, "Debe tener al menos 8 dígitos")
        .max(9, "No puede tener más de 9 dígitos"),

    email: z.string()
        .min(1, "El correo electrónico es obligatorio")
        .email("Ingresa un correo electrónico válido"),

    celular: z.string()
        .min(1, "El número de celular es obligatorio")
        .regex(/^9\d{8}$/, "El celular debe tener 9 dígitos y comenzar con 9"),

    producto: z.string()
        .min(1, "El producto es obligatorio")
        .max(200, "El producto es muy largo"),

    pedido: z.string()
        .min(1, "El pedido es obligatorio")
        .max(200, "El pedido es muy largo"),

    descripcion: z.string()
        .min(1, "El mensaje es obligatorio")
        .min(10, "El mensaje debe tener al menos 10 caracteres"),

    tipo: z.string().min(1, "Debes seleccionar un tipo")
        .refine((val) => tipos.value.some(doc => doc.valor === val), {
            message: "Tipo no es válido",
        }),
    
    descripcionTipo: z.string()
        .min(1, "El detalle es obligatorio")
        .max(200, "El detalle es muy largo"),

    descripcionPedido: z.string()
        .min(1, "El pedido es obligatorio")
        .max(200, "El pedido es muy largo"),

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
const { value: apellidos } = useField('apellidos')
const { value: tipo_documento } = useField('tipo_documento')
const { value: documento } = useField('documento')
const { value: email }   = useField('email')
const { value: celular } = useField('celular')
const { value: producto }  = useField('producto')
const { value: pedido } = useField('pedido')
const { value: descripcion } = useField('descripcion')
const { value: tipo } = useField('tipo')
const { value: descripcionTipo } = useField('descripcionTipo')
const { value: descripcionPedido } = useField('descripcionPedido')
const { value: checkedField } = useField('checked')   // importante para el checkbox

// Sincronizamos el ref del checkbox con vee-validate
watch(checked, (newVal) => {
  checkedField.value = newVal
})

watch(_tipo_documento, (newVal) => {
    tipo_documento.value = newVal
})

watch(_tipo, (newVal) => {
    tipo.value = newVal
})

const mensajeError = ref("")
const mensajeExito = ref("")

const onSubmit = handleSubmit(
  async (values) => {
    mensajeError.value = ""
    mensajeExito.value = ""
    console.log("Formulario enviado correctamente:", values);
    // Aquí haces la llamada a tu API
    // const _URL = `http://127.0.0.1:8000/api/v1/reclamacion/store`;
    const _URL = `http://branaperu.com/api/v1/reclamacion/store`;
      const response = await axios.post(_URL, {
        nombres: values.nombres,
        apellidos: values.apellidos,
        tipo_documento: values.tipo_documento,
        nro_documento: values.documento,
        nro_celular: values.celular,
        correo_electronico: values.email,
        producto: values.producto,
        nro_pedido: values.pedido,
        descripcion_bien: values.descripcion,
        tipo: values.tipo,
        detalle: values.descripcionTipo,
        pedido: values.descripcionPedido,
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
    } else if (errors.errors.apellidos) {
        mensajeError.value = 'Apellidos campo obligatorio';
    } else if (errors.errors.nombres){
        mensajeError.value = 'Nombres campo obligatorio';
    } else if (errors.errors.celular){
        mensajeError.value = 'Celular campo obligatorio';
    } else if (errors.errors.checked){
        mensajeError.value = 'Debe seleccionar los T&C';
    } else if (errors.errors.tipo_documento){
        mensajeError.value = 'Tipo de documento es un campo obligatorio';
    } else if (errors.errors.documento){
        mensajeError.value = 'Documento es un campo obligatorio';
    } else if (errors.errors.producto){
        mensajeError.value = 'Producto es un campo obligatorio';
    } else if (errors.errors.pedido){
        mensajeError.value = 'Pedido es un campo obligatorio';
    } else if (errors.errors.descripcion){
        mensajeError.value = 'Descripcion es un campo obligatorio';
    } else if (errors.errors.tipo){
        mensajeError.value = 'Tipo es un campo obligatorio';
    } else if (errors.errors.descripcionTipo){
        mensajeError.value = 'Detalle es un campo obligatorio';
    } else if (errors.errors.descripcionPedido){
        mensajeError.value = 'Descripcion de Pedido es un campo obligatorio';
    }
    
     
    else {
        mensajeError.value = "Por favor revisa los campos antes de continuar.";
    }
  }
)
</script>