<template>
    <div>
        <h1>Users</h1>
        <input type="text" placeholder="search..." v-model="searchQuery"/>
        <hr/>
        <table border="1">
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
            <tr v-for="user in results" v-bind:key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    import api from '../../../api';
    export default {
        name: 'IndexUsers',
        //components: {SortableHeader, Grid},
        data() {
            return {
                searchQuery: '',
                results: [],
            }
        },
        watch: {
            searchQuery: _.debounce(function(query) {
                api.usersSearch(query).then(response => {
                    this.results = response.data.data;
                });
            }, 300),
        }

    }
</script>

<style scoped="true">

</style>