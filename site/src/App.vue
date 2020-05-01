<template>
    <v-app>
        <component :is="layout"></component>
        <!--component :is="mobileLayout"></component-->
    </v-app>
</template>

<script>

    import MainLayout from "./components/layouts/MainLayout";
    import CompactLayout from "./components/layouts/CompactLayout";
    import NoLayout from "./components/layouts/NoLayout";
    import api from "./api";
    const default_layout = 'main-layout';
    export default {
        name: 'app',
        components: {
            MainLayout,
            CompactLayout,
            NoLayout,
        },
        data() {
            return {}
        },
        computed: {
            layout() {
                return (this.$route.meta.layout || default_layout);
            },
        },
        mounted() {
            if (!this.$store.profile && this.$store.getters.isLogged) {
                this.$store.dispatch('loadProfile');
            }
            this.$store.dispatch('loadSettings');

            // set ui colors...
            this.$vuetify.theme.themes.light.primary = '#' + this.$store.state.settings['appearance.colors.light.primary'];
            //this.$vuetify.theme.themes.dark.primary = '#002';
        },
    }
</script>

<style>
    html, body {
        height: 100%;
    }

    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        color: #2c3e50;
    }
</style>
