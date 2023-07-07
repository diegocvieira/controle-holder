<template id="header-template">
    <div style="display: flex; align-items: flex-end;">
        <header id="header">
            <button type="button" @click="openOrHideAside()">OPEN/HIDE</button>
        </header>

        <aside id="aside">
            <nav>
                <ul>
                    <li v-for="(item, key) in items" :key="key">
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
        props: ['page'],
        template: '#header-template',
        data () {
            return {
                choice: '',
                items: [
                    {
                        name: 'Dashboard',
                        slug: 'dashboard',
                        url: '/dashboard',
                        icon: `<svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M296 32h192c13.255 0 24 10.745 24 24v160c0 13.255-10.745 24-24 24H296c-13.255 0-24-10.745-24-24V56c0-13.255 10.745-24 24-24zm-80 0H24C10.745 32 0 42.745 0 56v160c0 13.255 10.745 24 24 24h192c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24zM0 296v160c0 13.255 10.745 24 24 24h192c13.255 0 24-10.745 24-24V296c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zm296 184h192c13.255 0 24-10.745 24-24V296c0-13.255-10.745-24-24-24H296c-13.255 0-24 10.745-24 24v160c0 13.255 10.745 24 24 24z"></path>
                            </svg>`,
                        dropdown_items: [],
                        is_active: false
                    },
                    {
                        name: 'Carteira',
                        slug: 'wallet',
                        url: '#',
                        icon: `<svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M461.2 128H80c-8.84 0-16-7.16-16-16s7.16-16 16-16h384c8.84 0 16-7.16 16-16 0-26.51-21.49-48-48-48H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h397.2c28.02 0 50.8-21.53 50.8-48V176c0-26.47-22.78-48-50.8-48zM416 336c-17.67 0-32-14.33-32-32s14.33-32 32-32 32 14.33 32 32-14.33 32-32 32z"></path>
                            </svg>`,
                        dropdown_items: [
                            {
                                name: 'Setor',
                                slug: '',
                                url: '#',
                                is_active: false
                            },
                            {
                                name: 'Alocação',
                                slug: '',
                                url: '#',
                                is_active: false
                            }
                        ],
                        is_active: false
                    },
                    {
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
                    },
                    {
                        name: 'Rebalanceamento',
                        slug: 'rebalancing',
                        url: '/dashboard/rebalancing',
                        icon: `<svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                <path fill="currentColor" d="M96 464v32c0 8.84 7.16 16 16 16h224c8.84 0 16-7.16 16-16V153.25c4.56-2 8.92-4.35 12.99-7.12l142.05 47.63c8.38 2.81 17.45-1.71 20.26-10.08l10.17-30.34c2.81-8.38-1.71-17.45-10.08-20.26l-128.4-43.05c.42-3.32 1.01-6.6 1.01-10.03 0-44.18-35.82-80-80-80-29.69 0-55.3 16.36-69.11 40.37L132.96.83c-8.38-2.81-17.45 1.71-20.26 10.08l-10.17 30.34c-2.81 8.38 1.71 17.45 10.08 20.26l132 44.26c7.28 21.25 22.96 38.54 43.38 47.47V448H112c-8.84 0-16 7.16-16 16zM0 304c0 44.18 57.31 80 128 80s128-35.82 128-80h-.02c0-15.67 2.08-7.25-85.05-181.51-17.68-35.36-68.22-35.29-85.87 0C-1.32 295.27.02 287.82.02 304H0zm56-16l72-144 72 144H56zm328.02 144H384c0 44.18 57.31 80 128 80s128-35.82 128-80h-.02c0-15.67 2.08-7.25-85.05-181.51-17.68-35.36-68.22-35.29-85.87 0-86.38 172.78-85.04 165.33-85.04 181.51zM440 416l72-144 72 144H440z"></path>
                            </svg>`,
                        dropdown_items: [],
                        is_active: false
                    },
                    {
                        name: 'Perfil',
                        slug: 'profile',
                        url: '#',
                        icon: `<svg viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12,19.2C9.5,19.2 7.29,17.92 6,16C6.03,14 10,12.9 12,12.9C14,12.9 17.97,14 18,16C16.71,17.92 14.5,19.2 12,19.2M12,5A3,3 0 0,1 15,8A3,3 0 0,1 12,11A3,3 0 0,1 9,8A3,3 0 0,1 12,5M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2Z"></path>
                            </svg>`,
                        dropdown_items: [],
                        is_active: false
                    },
                    {
                        name: 'Sair',
                        slug: 'logout',
                        url: '/api/auth/logout',
                        icon: `<svg viewBox="0 0 24 24">
                                <path fill="currentColor" d="M16,17V14H9V10H16V7L21,12L16,17M14,2A2,2 0 0,1 16,4V6H14V4H5V20H14V18H16V20A2,2 0 0,1 14,22H5A2,2 0 0,1 3,20V4A2,2 0 0,1 5,2H14Z"></path>
                            </svg>`,
                        dropdown_items: [],
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

                if (window.getComputedStyle(aside).width == '0px' || linkUrl != '#' && aside.classList.contains('aside-large')) {
                    aside.classList.toggle('aside-large');
                } else if (linkUrl === false || linkUrl == '#' && aside.classList.contains('aside-small')) {
                    aside.classList.toggle('aside-small');
                }
            }
        },
        mounted () {
            this.items.forEach(link => {
                if (link.slug === this.page) {
                    link.is_active = true;
                }

                link.dropdown_items.forEach(dropdownLink => {
                    if (dropdownLink.slug === this.page) {
                        dropdownLink.is_active = true;
                        link.is_active = true;
                        this.choice = link.slug;
                    }
                });
            });
        }
    }
</script>
