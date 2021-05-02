<template>
  <div style="margin-top: 20px;">
    <b-row sm="1" md="1" lg="3">
      <b-col
        v-for="(currentClass, indexClass) in ListClass"
        :key="indexClass"
        sm="4"
        style="cursor: pointer"
        @click="handleChooseClass(currentClass.id)"
      >
        <div class="card">
          <div class="card-body">
            <div class="zone-display-choose-class">
              <div class="icon-class">
                <i :class="handleRandomIcon()" />
              </div>
              <div class="text">
                <span>{{ currentClass.class_name }}</span>
              </div>
            </div>
          </div>
        </div>
      </b-col>
    </b-row>
  </div>
</template>

<script>
// Import function class api
import { getListFullClass } from '@/api/choose-class';

export default {
  name: 'ChooseClass',
  data() {
    return {
      ListClass: [],
    };
  },
  created() {
    this.handleGetListClass();
  },
  methods: {
    async handleGetListClass() {
      const ID_USER = {
        id: this.$store.getters.userId,
      };

      await getListFullClass(ID_USER)
        .then((response) => {
          this.ListClass = response.classes;
        });
    },

    handleChooseClass(id_class) {
      this.$store.dispatch('respondent/setIdClass', id_class)
        .then(() => {
          this.$router.push({ path: '/choose-course', query: this.otherQuery }, onAbort => {});
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
  .zone-display-choose-class {
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
