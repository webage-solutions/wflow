<template>
    <v-container fluid>
        <v-row>
            <v-col cols="4" v-for="(n, i) in 6" :key="i">
                <v-card class="ma-3">
                    <v-card-title>
                        Featured
                    </v-card-title>
                    <v-card-text>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque
                            dapibus
                            lacus eu nisl auctor mattis. Aenean sodales, neque non rutrum sagittis, metus dui pretium
                            justo
                        </p>
                        <v-btn color="primary">Go somewhere</v-btn>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: 'Home'
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
