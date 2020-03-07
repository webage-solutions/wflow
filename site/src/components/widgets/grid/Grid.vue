<template>
    <div>
        <div class="input-group">
            <div class="input-group-prepend">
                <a href="#" class="btn btn-success" @click="refresh"><i class="fa fa-sync"></i></a>
                <router-link to="/organizations/create" class="btn btn-primary"><i class="fa fa-plus"></i></router-link>
                <a href="#" class="btn btn-danger">
                    <i class="fa fa-trash"></i>
                </a>
                <span class="input-group-text"><i class="fa fa-search"></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Search..." @keyup="search($event.target.value)"/>
        </div>
        <hr/>
        <table class="table table-striped">
            <thead>
            <tr>
                <slot :query="query" :sortBy="sortBy" name="headers"></slot>
            </tr>
            <tr>
                <slot :filterBy="filterBy" name="filters"></slot>
            </tr>
            </thead>
            <tbody v-if="gridData === null">
            <tr>
                <td colspan="3">Loading...</td>
            </tr>
            </tbody>
            <tbody v-else-if="gridData.length === 0">
            <tr>
                <td colspan="3">No Organizations found.</td>
            </tr>
            </tbody>
            <tbody v-else>
            <tr v-for="(item, key) in gridData" :key="key">
                <slot :row="item" name="cells"></slot>
            </tr>
            </tbody>
        </table>
        <hr/>
        <div class="row" v-if="gridData !== null && gridData.length > 0">
            <nav aria-label="Page navigation" class="col pagination-panel">
                <ul class="pagination">
                    <li class="page-item" :class="{disabled: currentPage <= 1}">
                        <a class="page-link" href="#" aria-label="First" @click="goToPage(1)">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">First</span>
                        </a>
                    </li>
                    <li class="page-item" :class="{disabled: currentPage <= 1}">
                        <a class="page-link" href="#" aria-label="Previous" @click="goToPage(currentPage - 1)">
                            <span aria-hidden="true">&lsaquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <li v-for="(page, key) in shownPages" :key="key" class="page-item"
                        :class="{active: currentPage === page}">
                        <a class="page-link" href="#" @click="goToPage(page)">{{ page }}</a>
                    </li>
                    <li class="page-item" :class="{disabled: currentPage >= this.lastPage }">
                        <a class="page-link" href="#" aria-label="Next" @click="goToPage(currentPage + 1)">
                            <span aria-hidden="true">&rsaquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                    <li class="page-item" :class="{disabled: currentPage >= this.lastPage }">
                        <a class="page-link" href="#" aria-label="Last" @click="goToPage(lastPage)">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Last</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="col">
                Showing {{ pageTo - pageFrom + 1 }} items ({{ pageFrom }} to {{ pageTo }}) from {{ pageTotal }}.
            </div>
            <div class="col per-page-control">
                <div class="input-group" title="Items per page">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-file"></i></span>
                    </div>
                    <input type="text" class="form-control" v-model="perPage" @change="grabData()"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from 'lodash';
    export default {
        name: 'grid',
        props: {
            columns: Object,
            endpoint: String,
            initialQuery: {
                type: Object,
                default: () => ({})
            }
        },
        data() {
            return {
                gridData: null,
                currentPage: 1,
                shownPages: [1],
                lastPage: 1,
                pageFrom: 1,
                pageTo: 1,
                pageTotal: 1,
                perPage: null,
                query: this.initialQuery,
            }
        },
        methods: {
            goToPage: function(page) {
                Object.assign(this.query, {page});
                this.grabData();
            },
            sortBy: function(key) {
                let obj;
                if (this.query.sort === key) {
                    obj = { desc: this.query.desc ? 0 : 1 };
                } else {
                    obj = { sort: key };
                }
                Object.assign(this.query, obj);
                this.grabData();
            },
            filterBy: _.debounce(function (key, search) {
                key = `f_${key}`;
                if (search.length <= 2) {
                    if( this.query[key]) {
                        delete this.query[key];
                        this.grabData();
                    }
                    return;
                }
                Object.assign(this.query, { [key]: search });
                this.grabData();
            }, 500),
            search: _.debounce(function(searchText) {
                if (searchText.length <= 2) {
                    if (this.query.q) {
                        delete this.query.q;
                        this.grabData();
                    }
                    return;
                }
                Object.assign(this.query, {q: searchText});
                this.grabData();
            }, 500),
            refresh: _.throttle(function() {
                this.grabData();
            }, 2000),
            grabData: function() {
                this.gridData = null;
                if (this.perPage !== null) {
                    Object.assign(this.query, {perpage: this.perPage});
                }
                this.$api[this.endpoint](this.query).then(response => {
                    this.gridData = response.data.data;
                    this.currentPage = response.data.current_page;
                    this.lastPage = response.data.last_page;
                    this.shownPages = [];
                    for (let i = Math.max(this.currentPage - 2, 1); i <= Math.min(this.currentPage + 2, this.lastPage); i++) {
                        this.shownPages.push(i);
                    }
                    this.pageFrom = response.data.from;
                    this.pageTo = response.data.to;
                    this.pageTotal = response.data.total;
                    this.perPage = response.data.per_page;
                });
            }
        },
        mounted() {
            this.grabData();
        },
    }
</script>

<style scoped="true">
    .per-page-control {
        flex: 0 0 120px;
    }
    .pagination-panel {
        flex: 0 0 230px;
    }
</style>