<template>
    <div class="hello">
        <div class="row">
            <div class="col-4" v-for="n in 6">
                <div class="card m-3">
                    <div class="card-header">
                        Featured
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Dummy Title</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque
                            dapibus
                            lacus eu nisl auctor mattis. Aenean sodales, neque non rutrum sagittis, metus dui pretium
                            justo </p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Home'
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
