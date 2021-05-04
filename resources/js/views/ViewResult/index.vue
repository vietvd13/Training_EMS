<template>
  <div style="margin-top: 20px">
    <div class="zone-header-page">
      <b-row>
        <b-col sm="3">
          <b-form-input v-if="userRole !== ConstValue.ROLE.TRAINEE" v-model="isfilter.fullname" :placeholder="$t('views.view-result.search-fullname')" />
        </b-col>

        <b-col sm="3">
          <b-form-select v-model="isfilter.class" class="mb-3">
            <b-form-select-option :value="null">{{ $t('views.view-result.please-select-class') }}</b-form-select-option>
            <b-form-select-option
              v-for="(isClass, indexClass) in ListClass"
              :key="indexClass"
              :value="isClass.id"
            >
              {{ isClass.class_name }}
            </b-form-select-option>
          </b-form-select>
        </b-col>

        <b-col sm="3">
          <b-form-select v-model="isfilter.course" class="mb-3">
            <b-form-select-option :value="null">{{ $t('views.view-result.please-select-course') }}</b-form-select-option>
            <b-form-select-option
              v-for="(course, indexCourse) in ListCourse"
              :key="indexCourse"
              :value="course.course_id"
            >
              {{ course.course_name }}
            </b-form-select-option>
          </b-form-select>
        </b-col>

        <b-col sm="3">
          <b-form-select v-model="isfilter.test" class="mb-3">
            <b-form-select-option :value="null">{{ $t('views.view-result.please-select-test') }}</b-form-select-option>
            <b-form-select-option
              v-for="(test, indexTest) in ListTest"
              :key="indexTest"
              :value="test.test_id"
            >
              {{ test.test_name }}
            </b-form-select-option>
          </b-form-select>
        </b-col>
      </b-row>
    </div>

    <div class="zone-table">
      <div class="card">
        <div class="card-body">
          <b-overlay
            :show="overlay.show"
            :variant="overlay.variant"
            :opacity="overlay.opacity"
            :blur="overlay.blur"
            :rounded="overlay.sm"
          >
            <template #overlay>
              <div class="text-center">
                <b-icon icon="stopwatch" font-scale="3" animation="cylon" />
                <p id="cancel-label" style="margin-top: 10px;">{{ $t('overlay.loading') }}</p>
              </div>
            </template>

            <div class="zone-display-table">
              <b-table-simple
                :bordered="true"
                :outlined="false"
                :fixed="false"
              >
                <b-thead>
                  <b-tr>
                    <b-th>
                      <span>{{ $t('views.view-result.table.no') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.view-result.table.fullname') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.view-result.table.course') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.view-result.table.class') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.view-result.table.test') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.view-result.table.point') }}</span>
                    </b-th>
                  </b-tr>
                </b-thead>

                <b-tbody>
                  <b-tr
                    v-for="(result, indexResult) in ListResult"
                    :key="indexResult"
                  >
                    <b-td>
                      <span>{{ indexResult + 1 }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ result.name }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ result.course_name }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ result.class_name }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ result.test_name }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ result.grade }}</span>
                    </b-td>
                  </b-tr>
                </b-tbody>
              </b-table-simple>
            </div>
          </b-overlay>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// Import function helper
import { IsEmptyOrWhiteSpace } from '@/utils/validate';

// Import function call api
import { getListGradeTrainer, getListGradeTrainee, getListClass, getListCourse, getListTest } from '@/api/view-result';

// Import Const Value
import ConstValue from '../../../../const/const_value.json';

export default {
  name: 'ViewResult',
  data() {
    return {
      // Const value
      ConstValue: ConstValue,

      // Role
      userRole: this.$store.getters.roles.join(''),

      // Filter
      isfilter: {
        fullname: '',
        class: null,
        course: null,
        test: null,
      },

      // Overlay
      overlay: {
        show: true,
        variant: 'light',
        opacity: 1,
        blur: '1rem',
        rounded: 'sm',
      },

      ListResult: [],

      ListClass: [],
      ListCourse: [],
      ListTest: [],
    };
  },
  computed: {
    isFilterFullnameChange() {
      return this.isfilter.fullname;
    },
    isFilterClassChange() {
      return this.isfilter.class;
    },
    isFilterCourseChange() {
      return this.isfilter.course;
    },
    isFilterTestChange() {
      return this.isfilter.test;
    },
  },
  watch: {
    isFilterFullnameChange() {
      this.handleWatchFilter();
    },
    isFilterClassChange() {
      this.handleWatchFilter();
      this.isfilter.course = null;
      this.isfilter.test = null;
    },
    isFilterCourseChange() {
      this.handleWatchFilter();
      this.isfilter.test = null;
    },
    isFilterTestChange() {
      this.handleWatchFilter();
    },
  },
  created() {
    this.handleDoFilterByRole();
    this.handleWatchFilter();
  },
  methods: {
    handleWatchFilter() {
      const PARAMS_FILTER_CLASS = {
        'id': this.$store.getters.userId,
      };

      getListClass(PARAMS_FILTER_CLASS)
        .then((response) => {
          if (this.userRole === ConstValue.ROLE.TRAINEE) {
            this.ListClass = response.classes;
          } else {
            this.ListClass = response.classes_trainer;
          }

          if (this.isfilter.class !== null) {
            const PARAMS_FILTER_COURSE = {
              'id': this.isfilter.class,
            };

            getListCourse(PARAMS_FILTER_COURSE)
              .then((response) => {
                this.ListCourse = response.data;

                if (this.isfilter.class !== null && this.isfilter.course !== null) {
                  const PARAMS_FILTER_TEST = {
                    'class': this.isfilter.class,
                    'course': this.isfilter.course,
                  };

                  getListTest(PARAMS_FILTER_TEST)
                    .then((response) => {
                      this.ListTest = response.data;
                    });
                }
              });
          }
        });

      this.handleDoFilterByRole();
    },

    handleDoFilterByRole() {
      if (this.userRole === ConstValue.ROLE.TRAINEE) {
        this.handleGetGradeTrainee();
      } else {
        this.handleGetGradeTrainer();
      }
    },

    async handleGetGradeTrainer() {
      const isCheckFilterName = IsEmptyOrWhiteSpace(this.isfilter.fullname);
      const isFilterClass = this.isfilter.class;
      const isFilterCourse = this.isfilter.course;
      const isFilterTest = this.isfilter.test;

      var FILTER = this.handleCheckOption({
        'class': isFilterClass,
        'course': isFilterCourse,
        'test': isFilterTest,
      });

      if (isCheckFilterName !== true) {
        FILTER.full_name = this.isfilter.fullname;
      }

      await getListGradeTrainer(FILTER)
        .then((response) => {
          this.overlay.show = true;
          this.ListResult = response.data;
          this.overlay.show = false;
        });
    },

    async handleGetGradeTrainee() {
      const isCheckFilterClass = this.isfilter.class;
      const isCheckFilterCourse = this.isfilter.course;
      const isCheckFilterTest = this.isfilter.test;

      const FILTER = this.handleCheckOption({
        'class': isCheckFilterClass,
        'course': isCheckFilterCourse,
        'test': isCheckFilterTest,
      });

      await getListGradeTrainee(FILTER)
        .then((response) => {
          this.overlay.show = true;
          this.ListResult = response;
          this.overlay.show = false;
        });
    },

    handleCheckOption(obj) {
      var newObj = {};

      for (const [key, value] of Object.entries(obj)) {
        if (
          value !== null &&
          value !== undefined
        ) {
          newObj[key] = value;
        }
      }

      return newObj;
    },
  },
};
</script>

<style lang="scss" scoped>
  .zone-table {
    .zone-display-table {
      width: 100%;
      height: 730px;
      overflow-y: scroll;
    }

      th {
        background-color: #052c50;
        color: #fff;
        min-width: 50px;
        word-break: break-all;
        position: sticky;
        top: 0;
        left: 0;
        z-index: 1000;
      }

      th.zone-min-width {
        min-width: 170px;
        word-break: break-all;
      }

      td.zone-min-width {
        min-width: 170px;
        word-break: break-all;
      }

      td {
        min-width: 50px;
        word-break: break-all;
      }

      th, td {
        vertical-align: middle;
        text-align: center;
      }
  }
</style>
