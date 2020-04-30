<template>
    <v-navigation-drawer
            :value="value"
            v-on:input="$emit('input', $event)"
            temporary
            app
            overflow
            right
    >
        <form method="post" :action="logoutUrl" ref="logoutForm" style="display: none;"/>
        <v-list
                dense
                nav
                class="py-0"
        >
            <v-list-item two-line>
                <v-list-item-avatar
                        color="primary"
                        size="64"
                        class="text-center"
                >
                    <img v-if="avatar" :src="avatar" :alt="initials"/>
                    <div v-else class="white--text" style="width: 100%;">
                        {{ initials }}
                    </div>
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title>{{ userName }}</v-list-item-title>
                    <v-list-item-subtitle>
                        <router-link to="profile">Edit Profile</router-link>
                    </v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>

            <v-divider/>
            <v-list-item
                    link
                    @click="$router.push('settings')"
            >
                <v-list-item-icon>
                    <v-icon>fa-cog</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Settings</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-list-item
                    link
                    @click="logout()"
            >
                <v-list-item-icon>
                    <v-icon>logout</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-divider/>

            <template v-if="switchOrganizations.length > 1">
                <v-subheader>Switch Organization</v-subheader>
                <v-list-item v-for="(organization, i) in switchOrganizations.slice(0, shownOrganizations)" :key="i">
                    <v-list-item-avatar
                            color="primary"
                            size="32"
                            class="text-center"
                    >
    <!--                    <img v-if="avatar" :src="avatar" :alt="initials"/>-->
                        <div class="white--text overline" style="width: 100%;">
                            ORG
                        </div>
                    </v-list-item-avatar>

                    <v-list-item-content>
                        <v-list-item-title>{{ organization.name }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-btn
                        v-if="switchOrganizations.length > shownOrganizations"
                        right
                        x-small
                        text
                        rounded
                        class="mb-1"
                ><v-icon left x-small>fa-plus</v-icon> View all</v-btn>
                <v-divider/>
            </template>
            <v-subheader>Appearance & Behavior</v-subheader>
            <v-list-item class="my-3">
                <v-switch v-model="darkMode" label="Dark Mode"></v-switch>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    import api from '../../../api';
    export default {
        name: 'logged-user-menu',
        props: ['avatar', 'userName', 'initials', 'value'],
        data() {
            return {
                shownOrganizations: 2,
                darkMode: false,
            }
        },
        methods: {
            logout() {
                api.logout().then(() => {

                    // once logged out from the api, logout on the main app
                    this.$refs.logoutForm.submit();

                });
            }
        },
        computed: {
            logoutUrl() {
                return `${api.baseURL(true)}/web/logout`;
            },
            switchOrganizations() {
                const currentOrgId = this.$store.state.organization.id;
                return this.$store.getters.organizations.filter(org => org.id !== currentOrgId);
            },
        },
        watch: {
            darkMode: function(newValue) {
                this.$vuetify.theme.dark = newValue;
            },
        }
    }
</script>

<style scoped="true">

</style>