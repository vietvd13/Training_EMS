<template>
  <div class="lazyload" />
</template>

<script>
export default {
  name: 'LazyLoad',
  data() {
    return {
      lazyload: null,
    };
  },
  mounted() {
    this.lazyload = new IntersectionObserver(([entry]) => {
      if (entry && entry.isIntersecting) {
        this.$emit('lazyload');
      }
    });

    this.lazyload.observe(this.$el);
  },
};
</script>
