<template>
    <v-layout row wrap>
        <v-flex md12>
            <v-card>
                <v-card-text>
                    <v-autocomplete
                            v-model="model"
                            :items="items"
                            :loading="isLoading"
                            :search-input.sync="search"
                            color="white"
                            hide-no-data
                            hide-selected
                            item-text="name"
                            item-value="course"
                            label="Find unit"
                            placeholder="Unit name"
                            prepend-icon="mdi-database-search"
                            return-object
                    ></v-autocomplete>
                </v-card-text>
                <v-divider></v-divider>
                <v-expand-transition>
                    <v-list v-if="model">
                        <v-list-tile
                                v-for="(field, i) in fields"
                                :key="i"
                        >
                            <v-list-tile-content>
                                <v-list-tile-title v-text="field.value"></v-list-tile-title>
                                <v-list-tile-sub-title v-text="field.key.charAt(0).toUpperCase() + field.key.slice(1)"></v-list-tile-sub-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list>
                </v-expand-transition>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                            :disabled="!model"
                            @click="model = null"
                    >
                        Clear
                        <v-icon right>mdi-close-circle</v-icon>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
        <v-flex md12>
            <v-data-table
                    :headers="headers"
                    :items="courses"
                    :pagination.sync="pagination"
                    :total-items="totalItems"
                    :loading="loading"
                    class="elevation-1"
                    hide-actions
            >
                <template v-slot:items="props">
                    <td class="text-xs-left">{{ props.item.name }}</td>
                    <td class="text-xs-left">{{ props.item.language }}</td>
                    <td class="text-xs-left">{{ props.item.level }}</td>
                    <td class="text-xs-left">{{ props.item.units }}</td>
                </template>
            </v-data-table>
            <div class="text-xs-center pt-2">
                <v-pagination v-model="pagination.page" :length="pages"></v-pagination>
            </div>
        </v-flex>
    </v-layout>
</template>

<script>
  import {getCourses, searchUnits} from "../../services/api";

  const ITEMS_PER_PAGE = 10;
  const FIRST_DEFAULT_PAGE = 1;
  const DEFAULT_DESCENDING = null;
  const DEFAULT_SORT_BY = null;

  export default {
    name: "ContentTable",
    props: {
      languageId: {
        type: Number,
        default: 0
      },
      level: {
        type: Number,
        default: 0
      },
      textSearch: {
        type: String,
        default: ''
      },
      reset: {
        type: Boolean,
        default: false
      }
    },
    data() {
      return {
        descriptionLimit: 60,
        entries: [],
        isLoading: false,
        model: null,
        search: null,

        totalItems: 0,
        courses: [],
        loading: true,
        pagination: {},
        filter: {
          languageId: 0,
          level: 0,
          textSearch: ''
        },
        headers: [
          { text: 'Course', value: 'name' },
          { text: 'Language', value: 'language' },
          { text: 'Level', value: 'level' },
          { text: 'Units', value: 'units' }
        ]
      }
    },
    mounted() {
      this.pagination.rowsPerPage = ITEMS_PER_PAGE;
      this.pagination.page = FIRST_DEFAULT_PAGE;
      this.pagination.descending = DEFAULT_DESCENDING;
      this.pagination.sortBy = DEFAULT_SORT_BY;
      this.updateDataFromQueryParams();
    },
    watch: {
      pagination: {
        handler() {
          this.getCourses();
        },
        deep: true
      },
      languageId: {
        handler(_languageId) {
          this.filter.languageId = _languageId;
          this.getCourses();
        },
        deep: true
      },
      level: {
        handler(_level) {
          this.filter.level = _level;
          this.getCourses();
        },
        deep: true
      },
      textSearch: {
        handler(_textSearch) {
          this.filter.textSearch = _textSearch;
          this.getCourses();
        },
        deep: true
      },
      reset: {
        handler(_reset, _oldReset) {
          if (_reset !== _oldReset) {
            this.pagination.descending = null;
            this.pagination.page = 1;
            this.pagination.sortBy = null;
            this.filter.languageId = 0;
            this.filter.level = 0;
            this.filter.textSearch = '';
            this.resetQueryParams();
            this.getCourses();
          }
        }
      },
      search (val) {
        // Items have already been loaded
        if (this.items.length > 0) return;

        // Items have already been requested
        if (this.isLoading) return;

        this.isLoading = true;

        // Lazily load input items
        searchUnits(val)
            .then(result => {
              this.count = result.length;
              this.entries = result;
            })
            .finally(() => (this.isLoading = false))
      }
    },
    computed: {
      pages() {
        if (this.pagination.rowsPerPage == null ||
            this.pagination.totalItems == null
        ) return 0;

        return Math.ceil(this.pagination.totalItems / this.pagination.rowsPerPage)
      },
      fields () {
        if (!this.model) return [];

        return Object.keys(this.model).map(key => {
          return {
            key,
            value: this.model[key] || 'n/a'
          }
        })
      },
      items () {
        return this.entries.map(entry => {
          const name = entry.name.length > this.descriptionLimit
              ? entry.name.slice(0, this.descriptionLimit) + '...'
              : entry.name;

          return Object.assign({}, entry, { name })
        })
      }
    },
    methods: {
      getCourses() {
        this.loading = true;
        const { descending, page, rowsPerPage, sortBy } = this.pagination;
        const { languageId, level, textSearch } = this.filter;
        this.updateQueryParams();
        getCourses(page, rowsPerPage, sortBy, descending ? 'asc' : 'desc', languageId, level, textSearch)
            .then((result) => {
              this.courses = result.items;
              this.totalItems = result.pagination.totalItems;
              this.pagination.totalItems = this.totalItems;
              this.pagination.rowsPerPage = Number(result.pagination.rowsPerPage);
              this.loading = false;
            });
      },
      updateDataFromQueryParams() {
        const {
          descending,
          sortBy,
          languageId,
          level,
          textSearch
        } = this.$route.query;
        if (descending !== undefined) {
          this.pagination.descending = descending === 'true';
        }
        if (sortBy !== undefined) {
          this.pagination.sortBy = sortBy;
        }
        if (languageId !== undefined) {
          this.filter.languageId = Number(languageId);
        }
        if (level !== undefined) {
          this.filter.level = Number(level);
        }
        if (textSearch !== undefined) {
          this.filter.textSearch = textSearch;
        }
      },
      updateQueryParams() {
        const {
          descending,
          sortBy
        } = this.pagination;
        const {
          languageId,
          level,
          textSearch
        } = this.filter;
        let query = {};
        if (descending !== undefined && descending !== null) {
          query.descending = String(descending);
        }
        if (sortBy !== undefined && sortBy !== null) {
          query.sortBy = String(sortBy);
        }
        if (languageId) query.languageId = String(languageId);
        if (level) query.level = String(level);
        if (textSearch) query.textSearch = String(textSearch);

        this.$router.push({ name: 'content-table', query: query });
      },
      resetQueryParams() {
        this.$router.push({ name: 'content-table', query: {} });
      }
    }
  }
</script>

<style scoped>

</style>