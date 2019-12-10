<template>
    <div id="wrapper">
        <app-nav></app-nav>
        <router-view></router-view>
    </div>
</template>

<script>

    import appNav from './layout/Nav';

    export default {
        components: {
            appNav,
        }
    }
</script>
