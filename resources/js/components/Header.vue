<template>
    <header id="header">
        <button type="button" class="menu-hamburger" @click="toggleMenu">
            <svg v-if="isOpen" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            <svg v-else aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        </button>

        <div id="mobile-menu" v-if="isOpen">
            <ul>
                <li>
                    <a href="#" :class="{'is-active': $route.meta.menuSection === 'dashboard'}">Visão geral</a>
                </li>

                <li>
                    <a href="#" :class="{'is-active': $route.meta.menuSection === 'target-asset-classes'}">Meta de classes de ativos</a>
                </li>

                <li>
                    <a href="#" :class="{'is-active': $route.meta.menuSection === 'target-assets'}">Meta de ativos</a>
                </li>

                <li>
                    <a href="#" :class="{'is-active': $route.meta.menuSection === 'rebalancing'}">Rebalanceamento</a>
                </li>

                <li>
                    <a href="#" :class="{'is-active': $route.meta.menuSection === 'wallet'}">Carteira (em breve)</a>
                </li>

                <li>
                    <a href="#" :class="{'is-active': $route.meta.menuSection === 'profile'}">Perfil</a>
                </li>

                <li>
                    <a href="#" :class="{'is-active': $route.meta.menuSection === 'coffee'}">Me compre um café</a>
                </li>

                <li>
                    <a href="#" :class="{'is-active': $route.meta.menuSection === 'help'}">Ajuda</a>
                </li>

                <li>
                    <a href="#">
                        <svg viewBox="0 0 24 24">
                            <path fill="currentColor" d="M9.502 11.238a.75.75 0 1 0-.004 1.5zm11.493 1.306a.75.75 0 0 0 .002-1.061l-4.762-4.784a.75.75 0 1 0-1.063 1.059l4.233 4.252-4.252 4.233a.75.75 0 1 0 1.059 1.063zm-11.497.194 10.966.024.004-1.5-10.966-.024z"></path>
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M14.5 3h-9a2 2 0 0 0-2 2v15.053c0 .523.424.947.947.947H14.5"></path>
                        </svg>
                        Sair
                    </a>
                </li>
            </ul>
        </div>
    </header>
</template>

<script>
export default {
    props: {
        page: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            isOpen: false
        }
    },
    methods: {
        toggleMenu() {
            this.isOpen = !this.isOpen;
        }
    }
};
</script>
