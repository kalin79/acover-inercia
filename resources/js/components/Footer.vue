<template>
    <footer>
        <div class="containerFluid">
            <div class="headerFooterContainer">
                <div>
                    <div class="iconContainer">
                        <img :src="logo" alt="" />
                    </div>
                    <p>
                        ACOVER es una empresa especializada en lockers de <br/>
                        plástico y soluciones de protección <br />
y embalaje para el sector empresarial. 
                    </p>
                    <div class="redesContainer">
                        <a href="/">
                            <img :src="instagram" alt="">
                        </a>
                        <a href="/">
                            <img :src="Ln" alt="">
                        </a>
                        <a href="/">
                            <img :src="tiktok" alt="">
                        </a>
                    </div>
                </div>
                <div>
                    <h4>Mapa de sitio</h4>
                    <ul class="linkAcceso">
                       <li>
                            <a href="/">Principal</a>
                       </li>
                       <li>
                            <a href="/nosotros">Quienes somos</a>
                       </li>
                       <li>
                            <a href="/categoria/lockers">Lockers</a>
                       </li>
                       <li>
                            <a href="/categoria/material-de-embalaje">Material de embalaje</a>
                       </li>
                       <!-- <li>
                            <a href="/">Contáctenos</a>
                       </li>  -->
                    </ul>
                </div>
                <div>
                    <h4>Contacto</h4>
                    <div class="direccionContainer">
                        <div class="item">
                            <div class="iconContainer">
                                <img :src="local" alt="">
                            </div>
                            <div class="infoContainer">
                                <h5>Acover Trading</h5>
                                <p>
                                    Av. Los Tusilagos Mza. T Lote 41
                                </p>
                                <p>
                                    Urb. Los Jardines, Lima - SJL
                                </p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="iconContainer">
                                <img :src="icon5" alt="">
                            </div>
                            <div class="infoContainer">
                                <p>
                                    +51 903 233 717
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bodyFooterContainer">
                <p>© 2026 Acover Trading. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</template>

<script setup>
const logo= '/images/logofooter.svg';
const instagram= '/images/instagram.svg';
const Ln= '/images/Ln.svg';
const tiktok= '/images/tiktok.svg';
const local = '/images/ping.svg';
const icon5 = '/images/icon5.svg';
</script>
