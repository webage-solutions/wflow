<template>
    <div>
        <loading-message :message="message"></loading-message>
    </div>
</template>
<script>
    import axios from "axios";
    import LoadingMessage from "./LoadingMessage";
    import api from "../../api";

    export default {
        components: {LoadingMessage},
        props: ['message'],
        mounted() {
            const urlParams = new URLSearchParams(window.location.search);
            if (this.$store.state.oauthInfo.state !== urlParams.get('state')) {
                this.$router.push('/select-organization');
            }

            const requestData = {
                grant_type: 'authorization_code',
                client_id: 1,
                redirect_uri: 'http://localhost:8080/oauth-callback',
                code_verifier: this.$store.state.oauthInfo.codeVerifier,
                code: urlParams.get('code'),
            };

            axios.post('http://localhost/oauth/token', requestData). then(response => {
                this.$store.commit('setOauthToken', response.data);
                this.$store.dispatch('loadProfile');
                this.$router.push('/select-organization');
            });
        }
    };
</script>
<style>

</style>