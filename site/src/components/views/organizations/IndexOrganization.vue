<template>
    <div>
        <grid :endpoint="endpoint">
            <template v-slot:headers="{query, sortBy}">
                <sortable-header style="width: 50px;" :sort-by="sortBy" :query="query" field="id">#</sortable-header>
                <sortable-header :sort-by="sortBy" :query="query" field="name">Name</sortable-header>
                <th style="width: 100px;">Actions</th>
            </template>
            <template v-slot:filters="{filterBy}">
                <td style="width: 50px;">
                    <input type="text" style="width: 38px;"/>
                </td>
                <td>
                    <input type="text" @keyup="filterBy('name', $event.target.value)"/>
                </td>
                <td><i class="fa fa-filter"></i></td>
            </template>
            <template v-slot:cells="{row}">
                <td>{{ row.id }}</td>
                <td>{{ row.name }}</td>
                <td>
                    <a href="#"><i class="fa fa-edit"></i></a>
                    &nbsp;
                    <a href="#"><i class="fa fa-times-circle"></i></a>
                </td>
            </template>
        </grid>
    </div>
</template>

<script>
    import Grid from "../../widgets/grid/Grid";
    import SortableHeader from "../../widgets/grid/SortableHeader";
    export default {
        name: 'IndexOrganization',
        components: {SortableHeader, Grid},
        data() {
            return {
                endpoint: 'organizationsIndex'
            }
        },

    }
</script>

<style scoped="true">

</style>