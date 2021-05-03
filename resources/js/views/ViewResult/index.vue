<template>
  <div style="margin-top: 20px">
    <div class="zone-header-page">
      <b-row>
        <b-col v-if="userRole !== ConstValue.ROLE.TRAINEE" sm="3">
          <b-form-input v-model="isfilter.fullname" :placeholder="$t('views.view-result.search-fullname')" />
        </b-col>

        <b-col sm="3">
          <b-form-select v-model="isfilter.class" class="mb-3">
            <b-form-select-option :value="null">{{ $t('views.view-result.please-select-class') }}</b-form-select-option>
          </b-form-select>
        </b-col>

        <b-col sm="3">
          <b-form-select v-model="isfilter.course" class="mb-3">
            <b-form-select-option :value="null">{{ $t('views.view-result.please-select-course') }}</b-form-select-option>
          </b-form-select>
        </b-col>

        <b-col sm="3">
          <b-form-select v-model="isfilter.test" class="mb-3">
            <b-form-select-option :value="null">{{ $t('views.view-result.please-select-test') }}</b-form-select-option>
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
import { getListGradeTrainer, getListGradeTrainee } from '@/api/view-result';

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
    };
  },
  created() {
    this.handleDoFilterByRole();
  },
  methods: {
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

      if (isCheckFilterName === true) {
        FILTER.full_name = 'trainee';
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
