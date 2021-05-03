<template>
  <div style="margin-top: 20px;">
    <div class="card">
      <div class="card-body">
        <b-row>
          <b-col>
            <div class="zone-display-img-complete">
              <img :src="complete" alt="Complete Test">
            </div>

            <div class="zone-display-text-complete">
              <h1>{{ $t('complete') }}</h1>
            </div>

            <div class="zone-diplay-button-complete">
              <b-row>
                <b-col>
                  <b-button @click="backToDashboard()">{{ $t('back-to-home') }}</b-button>
                </b-col>

                <b-col>
                  <b-button @click="backToViewResult()">{{ $t('view-grade') }}</b-button>
                </b-col>
              </b-row>
            </div>
          </b-col>
        </b-row>
      </div>
    </div>
  </div>
</template>

<script>
// Import img
const complete = require('@/assets/images/complete.png');

export default {
  name: 'Complete',
  data() {
    return {
      complete: complete,
    };
  },
  created() {
    this.handleCheckCompleteTest();
  },
  methods: {
    handleCheckCompleteTest() {
      const GET_ID_TEST = this.$store.getters.respondent.selected.id_test;

      if (GET_ID_TEST === null) {
        this.$router.push({ path: '/dashboard/index', query: this.otherQuery }, onAbort => {});
      }
    },

    backToDashboard() {
      const SELECTED = {
        id_class: null,
        id_course: null,
        id_test: null,
      };

      this.$store.dispatch('respondent/setSelected', SELECTED)
        .then(() => {
          this.$router.push({ path: '/dashboard/index', query: this.otherQuery }, onAbort => {});
        });
    },

    backToViewResult() {
      const SELECTED = {
        id_class: null,
        id_course: null,
        id_test: null,
      };

      this.$store.dispatch('respondent/setSelected', SELECTED)
        .then(() => {
          this.$router.push({ path: '/view-result', query: this.otherQuery }, onAbort => {});
        });
    },
  },
};
</script>

<style lang="scss" scoped>
  .zone-display-img-complete {
    text-align: center;
    margin-top: 160px;
    margin-bottom: 50px;

    img {
      height: 400px;
      width: 400px;
    }
  }

  .zone-display-text-complete {
    margin-bottom: 60px;
    text-align: center;
  }

  .zone-diplay-button-complete {
    text-align: center;

    button {
      width: 80%;
      height: 70px;
      background-color: #fb8c00;
      border: none;

      &:hover {
        opacity: 0.7;
        background-color: #fb8c00;
      }

      &:focus {
        background-color: #fb8c00;
      }
    }
  }
</style>
