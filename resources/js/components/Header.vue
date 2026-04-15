<template>
    <div>
        <header class="headerContainerMain" ref="navbar">
            <div class="containerFluid">
                <div class="gridContainer">
                    <div class="logoContainer">
                        <Link :href="$route('home')" active-class="active">
                            <img :src="logo" alt="Logo de BRANA" width="120" height="33" loading="eager"/>
                        </Link>
                    </div>
                    <div class="navContainer">
                        <nav>
                            <div class="opcionesNav">
                                <Link :href="$route('home')" :class="{ 'active': page.url === '/' || page.url === '/home' }">Principal</Link>
                                <Link :href="$route('nosotros')" :class="{ 'active': page.url === '/nosotros' || page.url === '/nosotros' }">Nosotros</Link>
                                <Link :href="$route('category.show', { slug: 'lockers' })" :class="{ 'active': page.url === '/categoria/lockers'  }">Lockers</Link>
                                <Link :href="$route('category.show', { slug: 'material-de-embalaje' })" :class="{ 'active': page.url === '/categoria/material-de-embalaje' }">Material de embalaje</Link>
                            </div>
                            <button>Cotiza ahora</button>
                        </nav>
                        <div class="menuMovilNav" @click="handleViewMenu">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Menú móvil -->
        <div class="PanelMenuMobil" ref="PanelMenuMobil">
            <div class="contentBox">
                <div class="headerContainer">
                    <div class="logoContainer">
                        <img :src="logo" alt="Logo de BRANA" width="120" height="33" loading="eager"/>
                    </div>
                    <div class="closeContainer" @click="handleCloseMenu">
                        <img :src="imgClose" />
                    </div>
                </div>
                <div class="BodyContainer">
                    <Link :href="$route('home')" active-class="active">Principal</Link>
                    <Link :href="$route('nosotros')" active-class="active">Nosotros</Link>
                    <!-- <Link :href="$route('category.show', { slug: 'lockers' })" active-class="active">Lockers</Link>
                    <Link :href="$route('category.show', { slug: 'material-de-embalaje' })" active-class="active">Material de embalaje</Link> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
const logo = '/images/logo.svg';
const imgClose = '/images/close.svg';
</script>