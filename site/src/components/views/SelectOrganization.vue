<template>
    <div>
        <h4>Select Organization:</h4>
        <hr/>
        <ul>
            <li v-for="organization in organizations" :key="organization.id" class="my-2">
                <a href="#">
                    <img :src="organization.logo" class="organization-logo-img" :alt="organization.name" :title="organization.name" v-if="organization.logo"/>
                    <span v-else>{{ organization.name}}</span>
                </a>
            </li>
        </ul>
        <hr/>
        <a><span class="fa fa-building"></span> Manage Organizations</a>
    </div>
</template>

<script>
    import api from '../../api';
    export default {
        name: 'Home',
        methods: {
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
