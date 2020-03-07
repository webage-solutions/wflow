<template>
    <th>
        <a href="#" @click="sortBy(field)">
            <i class="fa fa-sort-alpha-down" v-if="query.sort === field && !query.desc"></i>
            <i class="fa fa-sort-alpha-down-alt" v-else-if="query.sort === field && query.desc"></i>
            <i class="fa fa-sort" v-else></i>
            <slot></slot>
        </a>
    </th>
</template>

<script>
    export default {
        name: 'sortable-header',
        props: ['sortBy', 'query', 'field'],
    };
</script>

<style scoped="true">

</style>