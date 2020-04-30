<template>
    <div class="h-100">
        <v-navigation-drawer
                v-model="leftDrawer"
                :clipped="false"
                :floating="false"
                :mini-variant="false"
                :permanent="false"
                :temporary="true"
                app
                overflow
        >
            <v-list
                    dense
            >
                <template v-for="(item, i) in items">
                    <v-row
                            v-if="item.heading"
                            :key="i"
                            align="center"
                    >
                        <v-col cols="6">
                            <v-subheader v-if="item.heading">
                                {{ item.heading }}
                            </v-subheader>
                        </v-col>
                        <v-col
                                cols="6"
                                class="text-right"
                        >
                            <v-btn
                                    small
                                    text
                            >edit</v-btn>
                        </v-col>
                    </v-row>
                    <v-divider
                            v-else-if="item.divider"
                            :key="i"
                            dark
                            class="my-4"
                    />
                    <v-list-item
                            v-else
                            :key="i"
                            link
                    >
                        <v-list-item-action>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title class="grey--text">
                                {{ item.text }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </template>
            </v-list>
        </v-navigation-drawer>
        <logged-user-menu :avatar="avatar" :initials="userInitials" :user-name="userName" v-model="rightDrawer"/>
        <v-app-bar
                app
        >
            <v-app-bar-nav-icon
                    @click.stop="leftDrawer = !leftDrawer"
            />
            <v-toolbar-title
                class="pa-0 mx-2"
            >
                <img :src="$store.getters.logo" alt="WFlow" class="top-logo d-none d-sm-block"/>
            </v-toolbar-title>
            <v-text-field
                    solo
                    rounded
                    flat
                    hide-details
                    dense
                    label="Search"
                    prepend-inner-icon="search"
                    class="mx-2"
            />
            <v-btn
                    icon
                    class="mx-2 d-none d-md-block d-lg-none"
            >
                <v-icon>fa-plus</v-icon>
            </v-btn>
            <v-btn
                text
                rounded
                class="d-none d-lg-block mx-2"
            >
                <v-icon left>fa-plus</v-icon> New Task
            </v-btn>
            <v-menu offset-y>
                <template v-slot:activator="{ on }">
                    <v-btn
                            icon
                            v-on="on"
                            class="mx-2 d-none d-md-block"
                    >
                        <v-icon>fa-bell</v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item>
                        <v-list-item-title>Alert 1</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-title>Alert 2</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>

            <v-avatar
                    color="primary"
                    size="32"
                    class="mx-2 d-lg-none"
                    @click.stop="rightDrawer = !rightDrawer"
                    style="cursor: pointer"
            >
                <img v-if="avatar" :src="avatar" :alt="userInitials"/>
                <span v-else class="white--text">{{ userInitials }}</span>
            </v-avatar>

            <v-btn
                    text
                    rounded
                    class="ml-2 pl-0 d-none d-lg-block"
                    @click.stop="rightDrawer = !rightDrawer"
            >
                <v-avatar
                        color="primary"
                        size="32"
                        class="mr-2"
                >
                    <img v-if="avatar" :src="avatar" :alt="userInitials"/>
                    <span v-else class="white--text">{{ userInitials }}</span>
                </v-avatar>
                {{ userFirstName }}
                <v-icon right size="small">fa-angle-double-left</v-icon>
            </v-btn>
<!--            >{{ userInitials }}</v-avatar>-->
        </v-app-bar>

        <v-content>
            <router-view></router-view>
        </v-content>
        <v-footer
                inset
                app
                padless
        >
            <v-btn
                    absolute
                    fab
                    top
                    right
                    color="primary"
                    class="d-md-none"
            >
                <v-icon>mdi-plus</v-icon>
            </v-btn>
            <v-card
                    flat
                    tile
                    width="100%"
                    class="text-center"
            >
                <v-tabs centered class="d-md-none">
                    <v-tab>
                        <v-btn icon><v-icon>fa-home</v-icon></v-btn>
                    </v-tab>
                    <v-tab>
                        <v-btn icon><v-icon>fa-bell</v-icon></v-btn>
                    </v-tab>
                </v-tabs>
                <v-divider></v-divider>
                <v-card-text class="d-none d-md-block">
                    &copy; {{ new Date().getFullYear() }} — <strong>Web Age - WFlow</strong>
                </v-card-text>
            </v-card>
        </v-footer>
    </div>
</template>

<script>
    import LoggedUserMenu from "./sections/LoggedUserMenu";
    import api from "../../api";
    export default {
        name: 'main-layout',
        components: {LoggedUserMenu},
        data() {
            return {
                uiLoaded: false,
                leftDrawer: null,
                rightDrawer: null,
                items: [
                    { icon: 'lightbulb_outline', text: 'Notes' },
                    { icon: 'touch_app', text: 'Reminders' },
                    { divider: true },
                    { heading: 'Labels' },
                    { icon: 'add', text: 'Create new label' },
                    { divider: true },
                    { icon: 'archive', text: 'Archive' },
                    { icon: 'delete', text: 'Trash' },
                    { divider: true },
                    { icon: 'settings', text: 'Settings' },
                    { icon: 'chat_bubble', text: 'Trash' },
                    { icon: 'help', text: 'Help' },
                    { icon: 'phonelink', text: 'App downloads' },
                    { icon: 'keyboard', text: 'Keyboard shortcuts' },
                ],
            }
        },
        mounted() {
            // asynchronously renew profile data
            // api.profile().then(response => {
            //     this.$store.dispatch('loadProfile');
            // });
            // this.uiLoaded = true;
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
                return state.profile ? state.profile.name : null;
            },
            userFirstName: function() {
                return this.userName.split(' ').shift();
            },
            userInitials: function() {
                const state = this.$store.state;
                return state.profile ? state.profile.name_initials : null;
            },
        },
    }
</script>

<style>

    .top-logo {
        height: 22px;
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