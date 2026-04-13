<template>
    <section class="pageLegaContainer">
        <!-- <Carousel :banners="homeData" /> -->
        <div class="containerFluid">
            <div class="gridLayout">
                <div>
                    <h1>POLÍTICA DE CAMBIOS, DEVOLUCIONES Y REEMBOLSOS BRANA PERÚ S.A.C.</h1>
                    
                    <h2>I. CONDICIONES DEL PRODUCTO</h2>
                    <p>
                       Para que un producto sea elegible para cambio, este deberá cumplir con las siguientes condiciones:
                    </p>
                    <ul>
                        <li>
                          Encontrarse en perfecto estado, sin señales de uso, manipulación o daño.
                        </li>
                        <li>
                           Mantener su empaque original, completo y en buen estado.
                        </li>
                        <li>
                            No haber sido abierto, alterado o consumido.
                        </li>
                        <li>
                            Conservar sus sellos de seguridad, de corresponder.
                        </li>
                    </ul>
                    <p>
                        En caso el producto no cumpla con las condiciones antes señaladas, BRANA no podrá reconocer el cambio solicitado.
                    </p>
                    <h2>II. PLAZO PARA SOLICITAR CAMBIOS</h2>
                    <p>
                        El cliente contará con un plazo máximo de 30 (treinta) días calendario contados desde la fecha de realización de la compra para solicitar el cambio del producto.
                        Vencido dicho plazo, no se aceptarán solicitudes de cambio bajo ningún concepto.
                    </p>
                    <h2>III. DOCUMENTACIÓN REQUERIDA</h2>
                    <p>
                        Para gestionar el cambio, el cliente deberá presentar:
                    </p>
                    <ul>
                        <li>
                            Documento de identidad válido (DNI, carné de extranjería o pasaporte).
                        </li>
                        <li>
                            Comprobante de pago correspondiente a la compra (boleta o factura), ya sea en formato físico o digital.
                        </li>
                    </ul>
                    <p>
                        La falta de alguno de estos documentos impedirá la atención del trámite.
                    </p>
                    <h2>IV. CAMBIOS Y NOTAS DE CRÉDITO</h2>
                    
                    <ul>
                        <li>
                            BRANA no realiza devoluciones de dinero en efectivo ni reembolsos a medios de pago.
                        </li>
                        <li>
                           En caso de cumplir con todas las condiciones establecidas en la presente política, se emitirá una nota de crédito por el valor del producto, la cual podrá ser utilizada para la adquisición de otros productos disponibles.
                        </li>
                        <li>
                           La nota de crédito tendrá una vigencia y condiciones de uso que serán informadas al momento de su emisión.
                        </li>
                    </ul>
                    <h2>V. COSTOS ASOCIADOS AL CAMBIO</h2>
                    <p>
                        Los costos logísticos derivados del cambio (envíos, traslados u otros) serán asumidos por el cliente, salvo que el cambio se origine por error atribuible a BRANA o por un defecto de fábrica del producto.
                    </p>
                    <h2>VI. CONSIDERACIONES FINALES</h2>
                    <p>
                        Debido a la naturaleza de los productos comercializados por BRANA (productos naturales, cosméticos, terapéuticos y de cuidado personal), no se aceptan cambios ni devoluciones de productos que hayan sido abiertos o utilizados, por razones de higiene, seguridad y control de calidad.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
<script setup>
import { ref, onMounted } from 'vue'

// import Carousel from '@/js/components/BannerMini.vue';
const homeData = ref(
    {
    "data": {
            "banners" : [
                {
                    "titulo": "Mente y cuerpo en equilibrio natural",
                    "descripcion": null,
                    "poster": "/images/frontend/bt3.webp",
                    "poster_mobile": "/images/frontend/bt3.webp",
                    "button": null,
                    "link": "/politica-de-cambio",
                    "abrir_otra_ventana": false,
                    "position": 1,
                    "active": true
                }
            ]
        },
    }
);
onMounted(() => {
  document.title = 'POLÍTICA DE CAMBIOS, DEVOLUCIONES Y REEMBOLSOS BRANA PERÚ S.A.C.';
  
  // Actualizar descripción
  let description = document.querySelector('meta[name="description"]');
  if (!description) {
    description = document.createElement('meta');
    description.name = 'description';
    document.head.appendChild(description);
  }
  description.content = 'Bienvenido a la seccion de Contancto';
});
</script>