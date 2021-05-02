<template>
  <div style="cursor: pointer" @click="letStart()">
    <b-row>
      <b-col>
        <div class="card">
          <div class="card-body">
            <div class="zone-diplay-start">
              <i class="icofont-brainstorming" />
              <h1>{{ $t('views.dashboard.start') }}</h1>
            </div>
          </div>
        </div>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  name: 'StartTest',
  data() {
    return {

    };
  },
  methods: {
    letStart() {
      this.$router.push({ path: '/choose-class', query: this.otherQuery }, onAbort => {});
    },
  },
};
</script>

<style lang="scss" scoped>
    .zone-diplay-start {
        padding-top: 20px;
        padding-bottom: 10px;
        text-align: center;

        i {
            font-size: 70px;
        }

        h1 {
            padding-top: 20px;
        }
    }
</style>
