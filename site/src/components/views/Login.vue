<template>
    <div>


        <form @submit="sendLogin">
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail
                    Address</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email"
                           v-model="username" required autocomplete="email" autofocus>


                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password"
                           v-model="password" required autocomplete="current-password">


                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember"
                               id="remember">

                        <label class="form-check-label" for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button class="btn btn-primary">
                        Login
                    </button>
                    <a class="btn btn-link" href="">
                        Forgot Your Password?
                    </a>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import api from '../../api';

    export default {
        name: 'login-view',
        data() {
            return {
                username: '',
                password: '',
            }
        },
        methods: {
            sendLogin: function (e) {

                api.login(this.username, this.password).then(data => {
                    this.$store.commit('setAuth', data);
                    const route = this.$store.state.organization ? '/' : '/select-organization'
                    this.$router.push(route);
                });

                e.preventDefault();
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
