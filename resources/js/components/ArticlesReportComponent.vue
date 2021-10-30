<template>
  <div>
    <div class="row justify-content-end">
      <div class="col-md-4">
        <div class="form-group">
          <div class="input-group">
            <input
              type="text"
              class="form-control form-control-lg"
              placeholder="Buscar..."
              aria-label="Buscar..."
              v-model="query"
              v-on:keyup.enter="refresh()"
            />
            <div class="input-group-append">
              <button
                class="btn btn-outline-secondary"
                type="button"
                @click="refresh()"
              >
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <template v-if="loading">
      <div class="d-flex justify-content-center">
        <loading-component></loading-component>
      </div>
    </template>
    <template v-else>
      <div class="row">
        <div
          class="col-md-4 mb-3"
          v-for="article of articles"
          v-bind:key="article.id"
        >
          <article-card-component v-bind="article"></article-card-component>
        </div>
      </div>
    </template>
  </div>
</template>

<script>
import axios from "axios";
import ArticleCardComponent from "./ArticleCardComponent.vue";
import LoadingComponent from "./LoadingComponent.vue";

export default {
  components: { ArticleCardComponent, LoadingComponent },
  data() {
    return {
      articles: [],
      loading: true,
      query: "",
    };
  },
  methods: {
    refresh() {
      this.loading = true;
      axios
        .get(`/api/articles${this.query ? `?query=${this.query}` : ""}`)
        .then((response) => (this.articles = response.data))
        .finally(() => (this.loading = false));
    },
  },
  mounted() {
    this.refresh();
  },
};
</script>

<style>
</style>