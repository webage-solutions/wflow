<template>
    <div>
        <a class="nav-link dropdown-toggle d-none d-sm-block" type="button" id="dropdownUserButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="avatar avatar-24" v-if="avatar===null">{{ initials }}</div>
            <img class="avatar avatar-24" v-else :src="avatar"/>&nbsp;
            <span class="d-none d-lg-inline">{{ userName }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownUserButton">
            <a class="dropdown-item" href="#" @click="logout">Log Out</a>
        </div>
    </div>
</template>

<script>
    import api from '../../../api';
    export default {
        name: 'logged-user-menu',
        props: ['avatar', 'userName', 'initials'],
        methods: {
            logout: function() {
                api.logout().finally(() => {
                    this.$router.push('/login');
                });
            }
        },

    }
</script>

<style scoped="true">
    .profile-userpic {
        margin: 0;
        width: 35px;
        height: 35px;
        border-radius: 9999px !important;
    }
</style>