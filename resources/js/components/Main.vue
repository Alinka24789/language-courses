<template>
    <main>
        <v-app fill-height>
            <v-container fluid grid-list-md>
                <v-layout row justify-space-between>
                    <h1>Find a Course</h1>
                    <v-btn color="primary" @click="logout">Logout</v-btn>
                </v-layout>
                <v-layout row wrap>
                    <v-flex md4>
                        <sidebar
                                @textSearch="updateTextSearch"
                                @languageId="updateLanguage"
                                @level="updateLevel"
                                @reset="updateReset"
                        ></sidebar>
                    </v-flex>
                    <v-flex md8 height="100%">
                        <contentTable
                                :languageId="languageId"
                                :level="level"
                                :text-search="textSearch"
                                :reset="reset"
                        ></contentTable>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-app>
    </main>
</template>

<script>
  import Sidebar from './sidebar/Sidebar'
  import ContentTable from './table/ContentTable'
  import {logout} from '../services/api';

  export default {
    components: {
      sidebar: Sidebar,
      contentTable: ContentTable
    },
    data: () => ({
      languageId: 0,
      level: 0,
      textSearch: '',
      reset: false
    }),
    mounted() {},
    methods: {
      updateTextSearch(variable) {
        this.textSearch = variable;
      },
      updateLanguage(variable) {
        this.languageId = variable;
      },
      updateLevel(variable) {
        this.level = variable;
      },
      updateReset(variable) {
        this.reset = variable;
      },
      logout() {
        logout();
      }
    }
  }
</script>
