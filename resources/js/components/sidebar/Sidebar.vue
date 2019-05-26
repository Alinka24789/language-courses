<template>
    <v-card>
        <v-card-text>
            <v-layout wrap>
                <v-flex md12>
                    <v-select
                            item-text="name"
                            item-value="id"
                            :items="languages"
                            v-model="languageId"
                            label="Language"
                            @change="sendLanguage"
                    ></v-select>
                    <v-select
                            v-model="level"
                            item-text="level"
                            item-value="level"
                            :items="levels"
                            label="Level"
                            @change="sendLevel"
                    ></v-select>
                    <v-text-field
                            v-model="textSearch"
                            label="Text"
                            placeholder="Course Name or Description"
                            @change="sendText"
                    ></v-text-field>
                </v-flex>
            </v-layout>
            <v-layout wrap justify-end>
                <v-btn flat color="primary" @click="reset">Reset</v-btn>
            </v-layout>
        </v-card-text>
    </v-card>
</template>

<script>
  import {getLanguages, getLevels} from "../../services/api";

  export default {
    name: "Sidebar",
    data: () => ({
      languages: [],
      languageId: 0,
      levels: [],
      level: 0,
      textSearch: '',
      isReset: false
    }),
    mounted() {
      this.init();
      this.updateDataFromQueryParams();
    },
    methods: {
      init() {
        getLanguages()
            .then((result) => {
              this.languages = result;
            });

        getLevels()
            .then((result) => {
              this.levels = result;
            })
      },
      sendText() {
        this.$emit('textSearch', this.textSearch);
      },
      sendLevel() {
        this.$emit('level', this.level);
      },
      sendLanguage() {
        this.$emit('languageId', this.languageId);
      },
      reset() {
        this.textSearch = '';
        this.level = 0;
        this.languageId = 0;
        this.sendText();
        this.sendLanguage();
        this.sendLevel();
        this.isReset = !this.isReset;
        this.$emit('reset', this.isReset);
      },
      updateDataFromQueryParams() {
        const {
          languageId,
          level,
          textSearch
        } = this.$route.query;
        if (languageId !== undefined) {
          this.languageId = Number(languageId);
        }
        if (level !== undefined) {
          this.level = Number(level);
        }
        if (textSearch !== undefined) {
          this.textSearch = textSearch;
        }
      }
    }
  }
</script>

<style scoped>

</style>