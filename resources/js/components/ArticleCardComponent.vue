<template>
  <div class="card h-100">
    <img
      v-if="high_resolution"
      v-bind:src="high_resolution.url"
      v-bind:alt="title"
    />
    <div class="card-body">
      <h5 class="card-title">{{ title }}</h5>
      <p class="card-text">{{ abstract }}</p>
      <p class="card-text">
        <small class="text-muted">{{ byline }}</small>
      </p>
      <a v-bind:href="url" target="_blank" rel="noopener noreferrer"
        >Read More</a
      >
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: String,
    abstract: String,
    byline: String,
    high_resolution: {
      type: Object,
      default: null,
    },
    url: String,
  },
};
</script>

<style>
</style>