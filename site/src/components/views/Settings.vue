<template>
    <v-container fluid class="pa-5">
        <v-row>
            <v-col cols="3">
                <v-card
                        class="mx-auto"
                        max-width="500"
                        shaped
                >
                    <v-sheet class="pa-4">
                        <v-text-field
                                v-model="search"
                                label="Search Settings"
                                flat
                                solo
                                outlined
                                hide-details
                                clearable
                                rounded
                                prepend-inner-icon="search"
                                clear-icon="mdi-close-circle-outline"
                                :loading="loadingSearch"
                                :disabled="loadingSearch"
                        ></v-text-field>
                    </v-sheet>
                    <v-divider/>
                    <v-card-text>
                        <v-skeleton-loader v-if="loadingMenu" type="list-item@2"></v-skeleton-loader>
                        <v-treeview
                                v-else
                                :items="shownItems"
                                :open.sync="open"
                                :active.sync="active"
                                dense
                                activatable
                                shaped
                        >
                        </v-treeview>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-divider vertical/>
            <v-col>
                <h1>{{ active[0] }}</h1>

            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: 'Settings',
        data() {
            return {
                loadingMenu: true,
                loadingSearch: true,
                active: [],
                settings: {},
                search: '',
                tree: [],
                open: [],
            }
        },
        methods: {
            loadSearch () {

                const settings = this.settings;

                const generateSearchField = item => {

                    // include the current name on the search
                    _.set(item, 'search', _.lowerCase(_.get(item, 'name', '')));

                    // include the settings of this item on the search
                    if (Object.values(settings).length) {
                        const fields = _.get(item, 'settings', []);
                        if (fields.length > 0) {
                            let fieldsSearch = fields.map(item => _.get(settings, [item, 'name'], '')).join(' ');
                            item.search += ` ${_.lowerCase(fieldsSearch)}`;
                        }
                    }

                    // go in depth into the children, doing the same
                    if (_.get(item, 'children', []).length > 0) {
                        item.children.forEach(generateSearchField);
                    }
                };

                this.tree.forEach(generateSearchField);

                this.loadingSearch = false;

            }
        },
        computed: {
            shownItems () {

                let active = [];
                let open = [];

                const query = this.search;

                const filter = (item) => {
                    // queries smaller than 3 are ignored
                    if (query.trim().length < 3) {
                        return true;
                    }

                    // by default consider that nothing was found
                    let found = false;

                    // first, go in depth to the children
                    let children = _.get(item, 'children', []);
                    if (children.length > 0) {
                        const filteredChildren = children.filter(filter);
                        if (filteredChildren.length) {
                            _.set(item, 'children', filteredChildren);
                            if (_.indexOf(open, item.id) === -1) {
                                open.push(item.id)
                            }
                            return true;
                        }
                    }

                    // try to find the query on the item search text
                    if (_.lowerCase(item.search).indexOf(_.lowerCase(query)) > -1) {
                        active = [];
                        active.push(item.id);
                        return true;
                    }

                    return found;

                };
                const deepSearch = (tree) => tree.filter(filter);

                const result = deepSearch(_.cloneDeep(this.tree));

                this.active = active;
                this.open = open;

                return result;

            }
        },
        mounted() {
            this.$api.settingsCategories().then(({data}) => {
                this.tree = data;
                this.loadSearch();
                this.loadingMenu = false;
            });
            this.$api.profileSettings().then(({data}) => {
                this.settings = data;
                this.loadSearch();
            });
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
