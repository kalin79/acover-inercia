<template>
    <section class="pageNosotrosContainer">
        <div class="headerContainer">
            <div class="fullImage">
                <img :src="img1" alt="" />
            </div>
            <div class="containerFluid">
                <div class="gridLayout">
                    <div>
                        <h2>NOSOTROS</h2>
                        <h1>
                            ACOVER es una empresa <br />
                            peruana especializada en <br />
                            la importación y <br />
                            comercialización de <br />
                            lockers de plástico y <br />
                            soluciones para la <br />
                            protección y embalaje de <br />
                            mercadería, orientada al <br />
                            sector empresarial.
                        </h1>
                        <p>
                            Desde el inicio de sus operaciones, desarrolla un <br />
                            portafolio de productos destinados a optimizar la <br />
                            organización, el uso eficiente de los espacios y el cuidado <br />
                            de los bienes, atendiendo a clientes de los sectores <br />
                            industrial, educación, pesquero y corporativo, con una <br />
                            proyección de crecimiento progresivo hacia nuevas <br />
                            soluciones que fortalezcan la eficiencia operativa de sus <br />
                            clientes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bodyContainer">
            <div class="containerFluid">
                <div class="gridLayout">
                    <div>
                        <h3>NUESTRA MISIÓN</h3>
                        <h2>
                            GENERAR ORDEN, SEGURIDAD Y EFICIENCIA EN <br />
                            LOS ENTORNOS OPERATIVOS DE NUESTROS <br />
                            CLIENTES
                        </h2>
                        <p>
                            A través de soluciones que facilitan la <br />
                            organización, la custodia y la protección de bienes y pertenencias. <br />
                            Creamos valor optimizando espacios y procesos, <br />
                            respaldados por una gestión responsable, enfoque en el <br />
                            cliente y relaciones comerciales sostenibles en el largo <br />
                            plazo.
                        </p>
                    </div>
                    <div>
                        <h3>NUESTRA VISIÓN</h3>
                        <h2>
                            CONSOLIDARNOS COMO EMPRESA REFERENTE <br />
                            A NIVEL NACIONAL EN SOLUCIONES <br />
                            CORPORATIVAS QUE APORTAN ORGANIZACIÓN
                        </h2>
                        <p>
                            control y cuidado de activos, reconocida por su <br />
                            capacidad de adaptación, crecimiento sostenido, <br />
                            confiabilidad y contribución tangible a la eficiencia <br />
                            operativa de los distintos sectores empresariales.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script setup>
import { ref, onMounted } from 'vue';
const img1 = '/images/s1.webp'
onMounted(() => {

    document.title = 'Acerca de Nosotros';

    // Actualizar descripción
    let description = document.querySelector('meta[name="description"]');
    if (!description) {
        description = document.createElement('meta');
        description.name = 'description';
        document.head.appendChild(description);
    }
    description.content = 'Bienvenido a la seccin de nosotros.';
});

</script>