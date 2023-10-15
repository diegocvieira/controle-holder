<template id="header-template">
    <div style="display: flex; align-items: flex-end;">
        <header id="header">
            <button id="hamburger" @click.prevent="openOrHideAside()">
                <svg id="ham-icon" version="1.1" viewBox="0 0 24 24">
                    <rect id="one" y="3" rx="1.25" ry="1.25" />
                    <rect id="two" y="11" rx="1.25" ry="1.25" />
                    <rect id="three" y="18" rx="1.25" ry="1.25" />
                </svg>
            </button>

            <a href="/dashboard">
                <img src="/resources/images/logo.png" class="logo" alt="HolderFolio" />
            </a>
        </header>

        <aside id="aside">
            <nav>
                <ul>
                    <li v-for="(item, key) in filteredItems" :key="key">
                        <a :href="item.url" class="link" :class="item.is_active == true ? 'is-active' : ''" v-on:click.prevent="handleLinkAction(item.slug, item.url)" :title="item.name">
                            <span class="icon" :class="item.slug" v-html="item.icon"></span>

                            {{ item.name }}

                            <span class="icon-dropdown" v-if="item.dropdown_items.length > 0">
                                <svg viewBox="0 0 24 24" v-if="!isActiveMenu(item.slug)">
                                    <path fill="currentColor" d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z"></path>
                                </svg>

                                <svg viewBox="0 0 24 24" v-else>
                                    <path fill="currentColor" d="M19,13H5V11H19V13Z"></path>
                                </svg>
                            </span>
                        </a>

                        <ul class="dropdown-menu" v-if="item.dropdown_items.length > 0" v-show="isActiveMenu(item.slug)">
                            <li v-for="(dropdown_item, key) in item.dropdown_items" :key="key">
                                <a :href="dropdown_item.url" class="link" :class="dropdown_item.is_active == true ? 'is-active' : ''">{{ dropdown_item.name}}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>
    </div>
</template>

<script>
    export default {
        name: 'header-component',
        props: ['page', 'is_logged'],
        template: '#header-template',
        data() {
            return {
                choice: '',
                loggedItems: [
                    {
                        name: 'Dashboard',
                        slug: 'dashboard',
                        url: '/dashboard',
                        icon: `<svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M296 32h192c13.255 0 24 10.745 24 24v160c0 13.255-10.745 24-24 24H296c-13.255 0-24-10.745-24-24V56c0-13.255 10.745-24 24-24zm-80 0H24C10.745 32 0 42.745 0 56v160c0 13.255 10.745 24 24 24h192c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24zM0 296v160c0 13.255 10.745 24 24 24h192c13.255 0 24-10.745 24-24V296c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zm296 184h192c13.255 0 24-10.745 24-24V296c0-13.255-10.745-24-24-24H296c-13.255 0-24 10.745-24 24v160c0 13.255 10.745 24 24 24z"></path>
                            </svg>`,
                        dropdown_items: [],
                        is_active: false
                    }, {
                        name: 'Carteira (em breve)',
                        slug: 'wallet',
                        url: '#',
                        icon: `<svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M461.2 128H80c-8.84 0-16-7.16-16-16s7.16-16 16-16h384c8.84 0 16-7.16 16-16 0-26.51-21.49-48-48-48H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h397.2c28.02 0 50.8-21.53 50.8-48V176c0-26.47-22.78-48-50.8-48zM416 336c-17.67 0-32-14.33-32-32s14.33-32 32-32 32 14.33 32 32-14.33 32-32 32z"></path>
                            </svg>`,
                        dropdown_items: [
                            // {
                            //     name: 'Setor',
                            //     slug: '',
                            //     url: '#',
                            //     is_active: false
                            // },
                            // {
                            //     name: 'Alocação',
                            //     slug: '',
                            //     url: '#',
                            //     is_active: false
                            // }
                        ],
                        is_active: false
                    }, {
                        name: 'Meta',
                        slug: 'target',
                        url: '#',
                        icon: `<svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12,11a1,1,0,1,0,1,1A1,1,0,0,0,12,11Zm0-9A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm1,17.93V17a1,1,0,0,0-2,0v2.93A8,8,0,0,1,4.07,13H7a1,1,0,0,0,0-2H4.07A8,8,0,0,1,11,4.07V7a1,1,0,0,0,2,0V4.07A8,8,0,0,1,19.93,11H17a1,1,0,0,0,0,2h2.93A8,8,0,0,1,13,19.93Z"></path>
                            </svg>`,
                        dropdown_items: [
                            {
                                name: 'Classes',
                                url: '/dashboard/target/asset-classes',
                                slug: 'target-asset-classes',
                                is_active: false
                            },
                            {
                                name: 'Ativos',
                                url: '/dashboard/target/assets',
                                slug: 'target-assets',
                                is_active: false
                            }
                        ],
                        is_active: false
                    }, {
                        name: 'Rebalanceamento',
                        slug: 'rebalancing',
                        url: '/dashboard/rebalancing',
                        icon: `<svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                <path fill="currentColor" d="M96 464v32c0 8.84 7.16 16 16 16h224c8.84 0 16-7.16 16-16V153.25c4.56-2 8.92-4.35 12.99-7.12l142.05 47.63c8.38 2.81 17.45-1.71 20.26-10.08l10.17-30.34c2.81-8.38-1.71-17.45-10.08-20.26l-128.4-43.05c.42-3.32 1.01-6.6 1.01-10.03 0-44.18-35.82-80-80-80-29.69 0-55.3 16.36-69.11 40.37L132.96.83c-8.38-2.81-17.45 1.71-20.26 10.08l-10.17 30.34c-2.81 8.38 1.71 17.45 10.08 20.26l132 44.26c7.28 21.25 22.96 38.54 43.38 47.47V448H112c-8.84 0-16 7.16-16 16zM0 304c0 44.18 57.31 80 128 80s128-35.82 128-80h-.02c0-15.67 2.08-7.25-85.05-181.51-17.68-35.36-68.22-35.29-85.87 0C-1.32 295.27.02 287.82.02 304H0zm56-16l72-144 72 144H56zm328.02 144H384c0 44.18 57.31 80 128 80s128-35.82 128-80h-.02c0-15.67 2.08-7.25-85.05-181.51-17.68-35.36-68.22-35.29-85.87 0-86.38 172.78-85.04 165.33-85.04 181.51zM440 416l72-144 72 144H440z"></path>
                            </svg>`,
                        dropdown_items: [],
                        is_active: false
                    }, {
                        name: 'Perfil',
                        slug: 'profile',
                        url: '#',
                        icon: `<svg viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12,19.2C9.5,19.2 7.29,17.92 6,16C6.03,14 10,12.9 12,12.9C14,12.9 17.97,14 18,16C16.71,17.92 14.5,19.2 12,19.2M12,5A3,3 0 0,1 15,8A3,3 0 0,1 12,11A3,3 0 0,1 9,8A3,3 0 0,1 12,5M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2Z"></path>
                            </svg>`,
                        dropdown_items: [
                            {
                                name: 'Conta',
                                url: '/dashboard/profile',
                                slug: 'account',
                                is_active: false
                            },
                            {
                                name: 'Sair',
                                url: '/api/auth/logout',
                                slug: 'logout',
                                is_active: false
                            }
                        ],
                        is_active: false
                    }
                ],
                items: [
                    {
                        name: 'Início',
                        slug: 'home',
                        url: '/',
                        icon: `<svg viewBox="0 0 500 500">
                                <path fill="currentColor" d="M250,90.5l-190,160h65v168h74v-68c0-28.12,22.88-51,51-51s51,22.88,51,51v68h74v-168h65L250,90.5z"></path>
                            </svg>`,
                        dropdown_items: [],
                        is_active: false
                    }, {
                        name: 'Login',
                        slug: 'login',
                        url: '/login',
                        icon: `<svg viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z"></path>
                            </svg>`,
                        dropdown_items: [],
                        is_active: false
                    }, {
                        name: 'Cadastro',
                        slug: 'register',
                        url: '/register',
                        icon: `<svg viewBox="0 0 14 14">
                                <path fill="currentColor" d="M6.904 2.994a2.008 2.008 0 0 0-2.008 2.01 2.008 2.008 0 0 0 2.008 2.008 2.008 2.008 0 0 0 2.008-2.008 2.008 2.008 0 0 0-2.008-2.01Zm-.047 5.014A3.983 3.983 0 0 0 3 11.014h4.965c-.025-.167-.053-.333-.053-.506 0-.781.267-1.495.701-2.078a3.937 3.937 0 0 0-1.756-.422zm4.553 0c-.64 0-1.28.243-1.767.73a2.504 2.504 0 0 0 0 3.537 2.504 2.504 0 0 0 3.537 0 2.504 2.504 0 0 0 0-3.537 2.495 2.495 0 0 0-1.77-.73zm-.498 1.002h1v.974h.998v1h-.998v1.018h-1v-1.018h-.994v-1h.994V9.01z"></path>
                            </svg>`,
                        dropdown_items: [],
                        is_active: false
                    }, {
                        name: 'Termos',
                        slug: 'terms',
                        url: '#',
                        icon: `<svg viewBox="0 0 24 24">
                                <path fill="currentColor" d="M13.191,0 C16.28,0 18,1.78 18,4.83 L18,4.83 L18,15.16 C18,18.26 16.28,20 13.191,20 L13.191,20 L4.81,20 C1.77,20 0,18.26 0,15.16 L0,15.16 L0,4.83 C0,1.78 1.77,0 4.81,0 L4.81,0 Z M5.08,13.74 C4.78,13.71 4.49,13.85 4.33,14.11 C4.17,14.36 4.17,14.69 4.33,14.95 C4.49,15.2 4.78,15.35 5.08,15.31 L5.08,15.31 L12.92,15.31 C13.319,15.27 13.62,14.929 13.62,14.53 C13.62,14.12 13.319,13.78 12.92,13.74 L12.92,13.74 Z M12.92,9.179 L5.08,9.179 C4.649,9.179 4.3,9.53 4.3,9.96 C4.3,10.39 4.649,10.74 5.08,10.74 L5.08,10.74 L12.92,10.74 C13.35,10.74 13.7,10.39 13.7,9.96 C13.7,9.53 13.35,9.179 12.92,9.179 L12.92,9.179 Z M8.069,4.65 L5.08,4.65 L5.08,4.66 C4.649,4.66 4.3,5.01 4.3,5.44 C4.3,5.87 4.649,6.22 5.08,6.22 L5.08,6.22 L8.069,6.22 C8.5,6.22 8.85,5.87 8.85,5.429 C8.85,5 8.5,4.65 8.069,4.65 L8.069,4.65 Z"></path>
                            </svg>`,
                        dropdown_items: [
                            {
                                name: 'Termos de Serviço',
                                url: '/legal/terms-of-service',
                                slug: 'terms-of-service',
                                is_active: false
                            },
                            {
                                name: 'Política de Privacidade',
                                url: '/legal/privacy-policy',
                                slug: 'privacy-policy',
                                is_active: false
                            }
                        ],
                        is_active: false
                    }
                ]
            }
        },
        methods: {
            handleLinkAction: function(linkSlug, linkUrl) {
                if (linkSlug === 'logout') {
                    axios.post(linkUrl, []).then(response => {
                        window.open('/login', '_self');
                    }).catch(error => console.log(error));
                } else if (linkUrl != '#') {
                    window.open(linkUrl, '_self');
                }

                this.openOrHideAside(linkUrl);
                this.openDropdown(linkSlug);
            },
            openDropdown: function(linkSlug) {
                this.choice = this.choice === linkSlug ? '' : linkSlug;
            },
            isActiveMenu: function(value) {
                return this.choice === value;
            },
            openOrHideAside: function(linkUrl = false) {
                const aside = document.getElementById('aside');
                const hamburger = document.getElementById('hamburger');

                if (linkUrl === false) {
                    hamburger.classList.toggle('open');
                }

                if (window.getComputedStyle(aside).width == '0px' || linkUrl != '#' && aside.classList.contains('aside-large')) {
                    aside.classList.toggle('aside-large');
                } else if (linkUrl === false || linkUrl == '#' && aside.classList.contains('aside-small')) {
                    aside.classList.toggle('aside-small');
                }
            }
        },
        mounted() {
            this.filteredItems.forEach(link => {
                if (link.slug === this.page) {
                    link.is_active = true;
                }

                link.dropdown_items.forEach(dropdownLink => {
                    if (dropdownLink.slug == this.page) {
                        dropdownLink.is_active = true;
                        link.is_active = true;
                        this.choice = link.slug;
                    }
                });
            });
        },
        computed: {
            filteredItems() {
                if (this.is_logged == true) {
                    return this.loggedItems;
                }

                return this.items;
            }
        }
    }
</script>
