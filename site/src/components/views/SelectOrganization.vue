<template>
    <div>
        <h4>Select Organization:</h4>
        <hr/>
        <ul>
            <li v-for="organization in organizations" :key="organization.id">
                <a href="#">
                    <img :src="organization.logo" class="organization-logo-img" :alt="organization.name" :title="organization.name" v-if="organization.logo"/>
                    <span v-else>{{ organization.name}}</span>
                </a>
            </li>
        </ul>
        <form method="post" action="http://localhost/auth/logout" ref="logoutForm" style="display: none;"/>
        <button class="btn btn-primary" @click="logout()"><span class="fa fa-sign-out-alt"></span> Logout</button>
    </div>
</template>

<script>
    import api from '../../api';
    export default {
        name: 'Home',
        methods: {
            logout() {
                api.logout().then(() => {

                    // once logged out from the api, logout on the main app
                    this.$refs.logoutForm.submit();

                });
            }
        },
        computed: {
            organizations() {
                const profile = this.$store.state.profile;
                if (profile) {
                    return profile.organizations;
                }
                return {};
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .organization-logo-img {
        height: 30px;
    }
</style>
