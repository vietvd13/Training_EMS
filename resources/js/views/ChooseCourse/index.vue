<template>
  <div style="margin-top: 20px">
    <b-row sm="1" md="1" lg="3">
      <b-col
        v-for="(currentCourse, indexCourse) in ListCourse"
        :key="indexCourse"
        sm="4"
        style="cursor: pointer"
        @click="handleChooseCourse(currentCourse.courese_id)"
      >
        <div class="card">
          <div class="card-body">
            <div class="zone-display-choose-course">
              <div class="icon-class">
                <i :class="handleRandomIcon()" />
              </div>
              <div class="text">
                <span>{{ currentCourse.course_name }}</span>
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
import { getListFullCourse } from '@/api/choose-course';

export default {
  name: 'ChooseCourse',
  data() {
    return {
      ListCourse: [],
    };
  },
  created() {
    this.handleGetListCourse();
  },
  methods: {
    async handleGetListCourse() {
      const GET_ID_CLASS = this.$store.getters.respondent.selected.id_class;
      if (GET_ID_CLASS !== null) {
        const ID_CLASS = {
          'id': GET_ID_CLASS,
        };

        await getListFullCourse(ID_CLASS)
          .then((response) => {
            this.ListCourse = response.data.class_course;
          });
      } else {
        this.$router.push({ path: '/choose-class', query: this.otherQuery }, onAbort => {});
      }
    },

    handleChooseCourse(id_course) {
      this.$store.dispatch('respondent/setIdCourse', id_course)
        .then(() => {
          this.$router.push({ path: '/choose-test', query: this.otherQuery }, onAbort => {});
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
  .zone-display-choose-course {
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
