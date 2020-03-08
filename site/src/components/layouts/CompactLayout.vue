<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <nav class="navbar navbar-expand  navbar-light bg-light p-0 d-flex">
                                <a class="navbar-brand collapse show multi-collapse mr-auto" id="topBarBrand" type="button">
                                    <img :src="logo" class="compact-logo"/>
                                </a>
                                <ul class="navbar-nav">
                                    <li class="nav-item dropdown">
                                        <logged-user-menu :avatar="avatar" :user-name="userName" :initials="userInitials"></logged-user-menu>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <div class="card-body compact-body">
                            <router-view></router-view>
                        </div>

                        <div class="card-footer">
                            Powered by WebAge - WFlow
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LoggedUserMenu from "./sections/LoggedUserMenu";
    export default {
        name: 'compact-layout',
        components: {LoggedUserMenu},
        computed: {
            logo: function() {
                return this.$store.getters.logo;
            },
            avatar: function() {
                return this.$store.getters.avatar;
            },
            userName: function() {
                const state = this.$store.state;
                return state.profile ? state.profile.name : null;
            },
            userInitials: function() {
                const state = this.$store.state;
                return state.profile ? state.profile.name_initials : null;
            },
        },
    }
</script>

<style scoped="true">
    .compact-logo {
        height: 30px;
    }
    .compact-body {
        min-height: 300px;
    }
</style>