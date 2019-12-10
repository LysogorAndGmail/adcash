<template>
    <nav id="primary-navigation" :class="{ active: mobile_toggle_nav }" class="mb-3">
        <div class="container" :class="{ active: mobileToggle }">
            <div data-simplebar data-simplebar-auto-hide="false">
                <ul class="clearfix">
                    <router-link :to="{name: 'dashboard'}" :class="{ 'current-menu-item': dashboard_nav }" tag="li"
                                 exact>
                        <a href="javascript:void(0)" class="d-flex align-items-center">
                            <span @click="hideNavigation,setActivLink('dashboard_nav')" class="hideNavigation">{{ $t("dashboard") }}</span>
                        </a>
                    </router-link>
                    <router-link :to="{name: 'admin.products'}"
                                 :class="{ 'current-menu-item': admin_nav }" tag="li">
                        <a href="javascript:void(0)" class="d-flex align-items-center">
                            <span @click="hideNavigation,setActivLink('admin_nav')" class="hideNavigation">{{ $t("admin") }}</span>
                        </a>
                    </router-link>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        data() {
            return {
                mobile_toggle_nav: false,
                active_link: '',
                dashboard_nav: false,
                companies_nav: false,
                workforces_nav: false,
                users_nav: false,
                settings_nav: false,
                admin_nav: false,
            };
        },
        computed: {
            permissions() {
                return this.$store.getters.getUserPermissions;
            },
            mobileToggle() {
                EventBus.$on('mobile_toggle', mobile_toggle => {
                    this.mobile_toggle_nav = mobile_toggle;
                });
            }
        },
        methods: {
            hideNavigation() {
                this.mobile_toggle_nav = false;
                EventBus.$emit('mobile_toggle', false);
            },
            setActivLink(link) {
                this.active_link = link;
                localStorage.active_link = link;
                
                this.dashboard_nav = false;
                this.companies_nav = false;
                this.workforces_nav = false;
                this.users_nav = false;
                this.settings_nav = false;
                this.admin_nav = false;

                switch (this.active_link) {
                    case 'dashboard_nav':
                        this.dashboard_nav = true;
                        break;
                    case 'companies_nav':
                        this.companies_nav = true;
                        break;
                    case 'workforces_nav':
                        this.workforces_nav = true;
                        break;
                    case 'users_nav':
                        this.users_nav = true;
                        break;
                    case 'settings_nav':
                        this.settings_nav = true;
                        break;
                    case 'admin_nav':
                        this.admin_nav = true;
                        break;
                }

            }
        },
        mounted() {
            if (localStorage.active_link) {
                this.active_link = localStorage.active_link;
            }
        },
        watch: {
            active_link(new_active_link) {
                localStorage.active_link = new_active_link;
            }
        }
    }
</script>

<style scoped>
    .hideNavigation {
        width: 100%;
    }

    .active {
        display: block !important;
    }
</style>