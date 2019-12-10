<template>
    <section id="content">
        <div class="container">
            <div class="element-header row align-items-center">
                <div class="col-md-auto mr-auto">
                    <h2>{{ $t("admin") }}</h2>
                </div>
            </div>
            <div class="element-body">
                <div class="row component-boxes">
                    <div class="col-12">
                        <div class="component-box box-white">
                            <div class="component-box-inner">
                                <div class="component-box-profile">
                                    <div class="user-profile-layout">
                                        <ul class="nav nav-tabs responsive">
                                            <li class="nav-item">
                                                <router-link :to="{name: 'admin.products'}" tag="a"
                                                             class="nav-link" active-class="active">
                                                    Products
                                                </router-link>
                                            </li>
                                            <li class="nav-item">
                                                <router-link :to="{name: 'admin.users'}" tag="a"
                                                             class="nav-link" active-class="active">
                                                    Users
                                                </router-link>
                                            </li>
                                        </ul>
                                        <router-view></router-view>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>