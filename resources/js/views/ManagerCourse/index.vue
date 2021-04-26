<template>
  <div style="margin-top: 20px">
    <div class="zone-header-page">
      <b-row>
        <b-col sm="4">
          <div class="zone-controls">
            <b-button @click="handleOpenModal()">{{ $t('views.manage-course.create-new') }}</b-button>
          </div>
        </b-col>
        <b-col sm="5" />
        <b-col sm="3">
          <div class="zone-controls">
            <b-form-input v-model="keySearch" :placeholder="$t('views.manage-course.enter-search')" />
          </div>
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
                  <b-th>
                    <span>{{ $t('views.manage-course.table.course-name') }}</span>
                  </b-th>

                  <b-th>
                    <span>{{ $t('views.manage-course.table.actions') }}</span>
                  </b-th>
                </b-thead>

                <b-tbody>
                  <b-tr v-for="(course, indexCourse) in ListCourse" :key="indexCourse">
                    <b-td />

                    <b-td>
                      <div class="zone-button-edit">
                        <b-button @click="handleOpenModal()">
                          {{ $t('views.manage-course.modal.edit') }}
                        </b-button>
                      </div>

                      <div class="zone-button-delete">
                        <b-button>
                          {{ $t('views.manage-course.modal.delete') }}
                        </b-button>
                      </div>
                    </b-td>
                  </b-tr>

                  <LazyLoad @lazyload="handleGetListCourse()" />
                </b-tbody>
              </b-table-simple>
            </div>
          </b-overlay>
        </div>
      </div>
    </div>

    <b-modal
      v-model="showModal"
      size="lg"
      centered
      :title="isAction === 'CREATE' ? $t('views.manage-course.modal.title-create') : $t('views.manage-course.modal.title-edit')"
    >
      <b-form-group
        label-cols="4"
        label-cols-lg="2"
        :label="$t('views.manage-course.modal.course-name')"
        label-for="input-course-name"
      >
        <b-form-input
          id="input-course-name"
          v-model="Course.cousre_name"
          :placeholder="$t('views.manage-course.modal.course-name')"
        />
      </b-form-group>

      <template #modal-footer>
        <div>
          <b-button
            v-if="isAction === 'CREATE'"
            @click="handleCreateCourse()"
          >
            {{ $t('views.manager-user.modal.create') }}
          </b-button>

          <b-button
            v-if="isAction === 'EDIT'"
            @click="handleUpdateCourse()"
          >
            {{ $t('views.manager-user.modal.save') }}
          </b-button>

          <b-button @click="showModal = false">
            {{ $t('views.manager-user.modal.close') }}
          </b-button>
        </div>
      </template>
    </b-modal>
  </div>
</template>

<script>
// Import function call api
import { getListCourse, postCreateCourse } from '@/api/manage-course';

// Import Component
import LazyLoad from '@/components/LazyLoad';

// Import function helper
import { handleNextPage } from '@/utils/lazyload';

// Import Toast
// import { MakeToast } from '@/utils/toast_message';

export default {
  name: 'ManageCourse',
  components: {
    LazyLoad,
  },
  data() {
    return {
      // Searching
      keySearch: '',

      // Overlay
      overlay: {
        show: true,
        variant: 'light',
        opacity: 1,
        blur: '1rem',
        rounded: 'sm',
      },

      // List Course
      ListCourse: [],

      // Modal
      showModal: false,

      // Action
      isAction: '',

      // Page
      page: 1,

      // Course
      Course: {
        id: '',
        cousre_name: '',
      },
    };
  },
  computed: {
    isCurrentPageChange() {
      return this.page;
    },
  },
  watch: {
    isCurrentPageChange() {
      if (this.page === 1) {
        this.ListCourse.length = 0;
        this.handleGetListCourse();
      }
    },
  },
  methods: {
    handleGetListCourse() {
      const length = this.ListCourse.length;

      this.page = handleNextPage(length);

      var param = {
        page: this.page,
      };

      getListCourse(param)
        .then((response) => {
          if (this.page > 1) {
            this.ListCourse = [...this.ListCourse, ...response.data];
          } else {
            this.ListCourse = [...response.data];
          }

          this.ListCourse = [...new Map(this.ListCourse.map(item => [item['id'], item])).values()];
          this.overlay.show = false;
        });
    },

    handleOpenModal() {
      this.showModal = true;

      this.isAction = 'CREATE';
    },

    isResetModal() {
      const COURSE = {
        id: '',
        course_name: '',
      };

      this.Course = COURSE;
    },

    handleCreateCourse() {
      const COURSE_NAME = this.Course.cousre_name;

      const COURSE = {
        'course_name': COURSE_NAME,
      };

      postCreateCourse(COURSE)
        .then((response) => {
          console.log(response);

          this.isResetModal();
          this.showModal = false;
          this.overlay.show = true;
          this.page = 1;
          this.overlay.show = false;
          this.handleGetListCourse();
        });
    },

    handleUpdateCourse() {

    },
  },
};
</script>

<style lang="scss" scoped>
  .zone-header-page {
    .zone-controls {
      margin-bottom: 20px;

      button {
        min-width: 150px;
        background-color: #67C23A;
        border: none;

        &:focus {
          background-color: #67C23A;
        }

        &:hover {
          opacity: 0.7;
        }
      }
    }
  }

  .zone-table {
    .zone-display-table {
      width: 100%;
      height: 730px;
      overflow-y: scroll;

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

      td.zone-button-control {
        width: 130px;
      }

      .zone-button-control {
        text-align: center;
        div + div {
          margin-top: 10px;
          margin-bottom: 10px;
        }
      }

      .zone-button-edit {
        button {
          min-width: 150px;
          background-color: #E6A23C;
          border: none;
        }

          &:hover {
            opacity: 0.7;
          }
      }

      .zone-button-delete {
        button {
          min-width: 150px;
          background-color: #F56C6C;
          border: none;

          &:hover {
            opacity: 0.7;
          }
        }
      }
    }
  }
</style>
