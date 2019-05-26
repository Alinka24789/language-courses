<template>
    <v-layout row wrap>
        <v-flex md12>
            <v-card>
                <v-card-text>
                    <v-text-field
                            v-model="search"
                            label="Find unit"
                            placeholder="Unit name"
                    ></v-text-field>
                </v-card-text>
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
  import {getCourses} from "../../services/api";

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
        search: '',
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
      }
    },
    computed: {
      pages() {
        if (this.pagination.rowsPerPage == null ||
            this.pagination.totalItems == null
        ) return 0;

        return Math.ceil(this.pagination.totalItems / this.pagination.rowsPerPage)
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