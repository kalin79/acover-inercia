<template>
    <div class="compraHomeSeccion">
        <div class="fullImage">
            <img :src="imgfull" alt="">
        </div>
        <div class="containerFluid">
            <div class="gridLayout">
                <div>
                    <div class="headerContainer">
                        <h2>COMPRA FÁCIL, SEGURA <br />Y ACOMPAÑADA</h2>
                        <p>
                            Adquiera sus lockers en minutos siguiendo estos tres pasos:
                        </p>
                    </div>
                    <div class="listCompras">
                        <div class="itemContainer" v-for="(item, index) in compraData" :key="index">
                            <div class="iconContainer">
                                <img :src="item.icon" alt="">
                            </div>
                            <div class="infoContainer">
                                <h3 v-html="item.titulo"></h3>
                                <p v-html="item.descripcion"></p>
                            </div>
                        </div>
                    </div>
                    <div class="listComprasM">
                        <div class="itemContainer" v-for="(item, index) in compraData" :key="index">
                            <div class="iconContainer">
                                <img :src="item.icon" alt="">
                                <h3 v-html="item.titulo"></h3>
                            </div>
                            <div class="infoContainer">
                                <p v-html="item.descripcion"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const imgfull = '/images/full.webp'
const compraData = [
    {
        titulo: `Asesoría inmediata <br />
                                    y profesional`,
        descripcion: `Contáctenos por WhatsApp o vía directa con un asesor comercial. Recibirá orientación técnica, información clara sobre materiales, tiempos y condiciones.`,
        icon: '/images/icon1.svg'
    },
    {
        titulo: `Eliga su solución ideal`,
        descripcion: `Revise nuestro catálogo o indíquenos el modelo, medidas y cantidad que necesita.
Si no está seguro, lo asesoramos para elegir la mejor configuración según su operación.`,
        icon: '/images/icon2.svg'
    },
    {
        titulo: `Cotización formal y <br />entrega garantizada`,
        descripcion: `Reciba su presupuesto final con fecha de entrega garantizada y coordinamos el envío.`,
        icon: '/images/icon3.svg'
    }
]
</script>