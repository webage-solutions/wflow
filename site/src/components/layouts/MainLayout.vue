<template>
    <div class="h-100">
        <loading-screen v-if="!uiLoaded"></loading-screen>
        <div class="row h-100 no-gutters" v-else>
            <div class="col">
                <nav class="navbar navbar-expand  navbar-light bg-light p-0 d-flex">
                    <a class="nav-link px3" type="button"><span class="fa fa-angle-double-right" data-toggle="modal" data-target="#sidebarContainer"></span></a>
                    <a class="navbar-brand collapse show multi-collapse" id="topBarBrand" type="button">
                        <img :src="$store.getters.logo" class="top-logo"/>
                    </a>
                    <form class="form my-2 my-lg-0 flex-grow-1 d-sm-none" id="smSearchForm">
                        <input class="form-control form-control-sm mr-sm-2 collapse multi-collapse" type="search" placeholder="Search" aria-label="Search" id="topBarSmSearchInput">
                    </form>
                    <a class="nav-link px3 d-sm-none collapse show multi-collapse" id="topBarSmSearchOpenButton" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="topBarSmSearchInput topBarBrand topBarNewTaskButtonContainer topBarAlertsButtonContainer topBarSmSearchOpenButton topBarSmSearchCloseButton">
                        <span class="fa fa-search"></span>
                    </a>
                    <a class="nav-link px3 d-sm-none collapse multi-collapse" id="topBarSmSearchCloseButton" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="topBarSmSearchInput topBarBrand topBarNewTaskButtonContainer topBarAlertsButtonContainer topBarSmSearchOpenButton topBarSmSearchCloseButton">
                        <span class="fa fa-times-circle"></span>
                    </a>
                    <form class="form my-2 my-lg-0 flex-grow-1 d-none d-sm-block">
                        <input class="form-control form-control-sm mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    </form>
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item collapse show multi-collapse" id="topBarNewTaskButtonContainer">
                            <a class="nav-link px-3" type="button">
                                <span class="fa fa-plus"></span>&nbsp;<span class="d-none d-lg-inline">New Task</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown" id="topBarAlertsButtonContainer">
                            <a class="nav-link dropdown-toggle" type="button" id="dropdownAlertsButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fa fa-bell fa-lg"></span>
                                <span class="badge badge-pill badge-primary">9</span>
                                <span class="sr-only">Unread Alerts</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownAlertsButton">
                                <a class="dropdown-item" href="#">Alert 1</a>
                                <a class="dropdown-item" href="#">Alert 2</a>
                                <a class="dropdown-item" href="#">Alert 3</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <logged-user-menu :avatar="avatar" :user-name="userName" :initials="userInitials"></logged-user-menu>
                        </li>
                    </ul>
                </nav>
                <nav class="modal left fade" id="sidebarContainer" tabindex="-1" role="navigation" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="navigation">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span class="fa fa-angle-double-left"></span>
                                </button>
                                <nav class="nav flex-sm-column flex-row">
                                    <div style="text-align: center">
                                        <div class="avatar avatar-96" v-if="avatar===null">{{ userInitials }}</div>
                                        <img class="avatar avatar-96" v-else :src="avatar" alt=""/>
                                        <p>{{ userName }}</p>
                                    </div>
                                    <router-link to="/" class="nav-link">Home</router-link>
                                    <router-link to="/wflow-editor" class="nav-link">Editor</router-link>
                                    <router-link to="/organizations/index" class="nav-link">Organizations</router-link>
                                </nav>
                            </div>
                        </div>
                    </div>
                </nav>
                <div class="h-100 d-flex flex-column">
                    <div class="row  main-content-container main-content-container-colors flex-grow-1">
                        <div class="col m-3">
                            <router-view></router-view>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LoggedUserMenu from "./sections/LoggedUserMenu";
    import LoadingScreen from "./sections/LoadingScreen";
    import api from "../../api";
    export default {
        name: 'main-layout',
        components: {LoadingScreen, LoggedUserMenu},
        data() {
            return {
                uiLoaded: false,
            }
        },
        mounted() {

            // asynchronously renew profile data
            api.profile().then(response => {
                this.$store.commit('setUser', response.data);
            });
            this.uiLoaded = true;
        },
        methods: {

        },
        computed: {
            logo: function() {
                return this.$store.getters.logo;
            },
            avatar: function() {
                return this.$store.getters.avatar;
            },
            userName: function() {
                const state = this.$store.state;
                return state.auth ? state.profile.name : null;
            },
            userInitials: function() {
                const state = this.$store.state;
                return state.auth ? state.profile.name_initials : null;
            },
        },
    }
</script>

<style>
    .modal.left .modal-dialog {
        position:fixed;
        left: 0;
        margin: auto;
        width: 280px;
        height: 100%;
        -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0);
    }

    .modal.left .modal-content {
        height: 100%;
        overflow-y: auto;
    }

    /* ----- MODAL STYLE ----- */
    .modal-content {
        border-radius: 0;
        border: none;
    }


    .main-content-container {
    }

    .top-logo {
        height: 22px;
    }

    .avatar {
        display: inline-block;
        position: relative;
        background: grey;
        width: 256px;
        height: 256px;
        line-height: 256px;
        color: #fff;
        text-align: center;
        border-radius: 300px;
        background-size: cover!important;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-box-flex: 0;
        -ms-flex-positive: 0;
        flex-grow: 0;
        -ms-flex-negative: 0;
        flex-shrink: 0;
        -webkit-box-sizing: content-box;
        box-sizing: content-box;
    }

    .avatar-24 {
        width: 24px;
        height: 24px;
        line-height: 24px;
        font-size: 10px;
    }

    .avatar-32 {
        width: 32px;
        height: 32px;
        line-height: 32px;
        font-size: 18px;
    }

    .avatar-48 {
        width: 48px;
        height: 48px;
        line-height: 48px;
        font-size: 24px;
    }

    .avatar-64 {
        width: 64px;
        height: 64px;
        line-height: 64px;
        font-size: 32px;
    }

    .avatar-96 {
        width: 96px;
        height: 96px;
        line-height: 96px;
        font-size: 40px;
    }

    .avatar-128 {
        width: 128px;
        height: 128px;
        line-height: 128px;
        font-size: 50px;
    }
</style>