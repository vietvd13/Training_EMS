<template>
  <div style="margin-top: 20px">
    <b-row sm="1" md="1" lg="3">
      <b-col
        v-for="(currentTest, indexTest) in ListTest"
        :key="indexTest"
        sm="4"
        style="cursor: pointer"
        @click="handleChooseTest(currentTest.test_id)"
      >
        <div class="card">
          <div class="card-body">
            <div class="zone-display-choose-test">
              <div class="icon-class">
                <i :class="handleRandomIcon()" />
              </div>
              <div class="text">
                <span>{{ currentTest.test_name }}</span>
              </div>
            </div>
          </div>
        </div>
      </b-col>
    </b-row>
  </div>
</template>

<script>
// Import function call api
import { getListTest } from '@/api/choose-test';

export default {
  name: 'ChooseTest',
  data() {
    return {
      ListTest: [],
    };
  },
  created() {
    this.handleGetListTest();
  },
  methods: {
    handleGetListTest() {
      const GET_ID_CLASS = this.$store.getters.respondent.selected.id_class;
      const GET_ID_COURSE = this.$store.getters.respondent.selected.id_course;

      if (GET_ID_CLASS !== null && GET_ID_COURSE !== null) {
        const PARAMS = {
          'class': GET_ID_CLASS,
          'course': GET_ID_COURSE,
        };

        getListTest(PARAMS)
          .then((response) => {
            this.ListTest = response.data;
          });
      } else {
        this.$router.push({ path: '/choose-course', query: this.otherQuery }, onAbort => {});
      }
    },

    handleChooseTest(id_test) {
      this.$store.dispatch('respondent/setIdTest', id_test)
        .then(() => {
          this.$router.push({ path: '/do-test', query: this.otherQuery }, onAbort => {});
        })
        .catch((err) => {
          console.log(err);
        });
    },

    handleRandomIcon() {
      const LIST_ICON = [
        'icofont-brain-alt',
        'icofont-rocket-alt-2',
        'icofont-micro-chip',
        'icofont-electron',
        'icofont-law-alt-3',
        'icofont-teddy-bear',
        'icofont-toy-duck',
        'icofont-chart-histogram-alt',
        'icofont-penguin-linux',
        'icofont-paint',
        'icofont-lock',
        'icofont-magic',
        'icofont-navigation',
        'icofont-light-bulb',
      ];

      return LIST_ICON[Math.floor((Math.random() * LIST_ICON.length))];
    },
  },
};
</script>

<style lang="scss" scoped>
  .zone-display-choose-test {
    .icon-class {
      text-align: center;
      font-size: 40px;
      margin-bottom: 10px;
    }

    .text {
      text-align: center;
      font-size: 20px;
      font-weight: 600;
    }
  }
</style>
