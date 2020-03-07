<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <img :src="$store.getters.logo" class="login-logo"/>
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
    export default {
        name: 'compact-layout'
    }
</script>

<style scoped="true">
    .login-logo {
        height: 30px;
    }
    .compact-body {
        min-height: 300px;
    }
</style>