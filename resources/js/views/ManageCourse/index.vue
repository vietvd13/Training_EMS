<template>
  <div style="margin-top: 20px">
    <div class="zone-header-page">
      <b-row>
        <b-col sm="4">
          <div class="zone-controls">
            <b-button @click="handleOpenModal(null, null)">{{ $t('views.manage-course.create-new') }}</b-button>
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
                    <span>{{ $t('views.manage-course.table.no') }}</span>
                  </b-th>

                  <b-th>
                    <span>{{ $t('views.manage-course.table.id') }}</span>
                  </b-th>

                  <b-th>
                    <span>{{ $t('views.manage-course.table.course-name') }}</span>
                  </b-th>

                  <b-th>
                    <span>{{ $t('views.manage-course.table.actions') }}</span>
                  </b-th>
                </b-thead>

                <b-tbody>
                  <b-tr v-for="(course, indexCourse) in ListCourse" :key="indexCourse">
                    <b-td>
                      <span>{{ indexCourse + 1 }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ course.course_id }}</span>
                    </b-td>

                    <b-td class="zone-min-width">
                      <span>{{ course.course_name }}</span>
                    </b-td>

                    <b-td class="zone-button-control">
                      <div class="zone-button-edit">
                        <b-button @click="handleOpenModal(course, indexCourse)">
                          {{ $t('views.manage-course.table.edit') }}
                        </b-button>
                      </div>

                      <div class="zone-button-delete">
                        <b-button @click="handleDeleteCourse(course.course_id)">
                          {{ $t('views.manage-course.table.delete') }}
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
      id="modal-course"
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
          v-model="Course.course_name"
          :placeholder="$t('views.manage-course.modal.course-name')"
        />
      </b-form-group>

      <template #modal-footer>
        <div>
          <b-button
            v-if="isAction === 'CREATE'"
            @click="handleCreateCourse()"
          >
            {{ $t('views.manage-user.modal.create') }}
          </b-button>

          <b-button
            v-if="isAction === 'EDIT'"
            @click="handleUpdateCourse()"
          >
            {{ $t('views.manage-user.modal.save') }}
          </b-button>

          <b-button @click="showModal = false">
            {{ $t('views.manage-user.modal.close') }}
          </b-button>
        </div>
      </template>
    </b-modal>
  </div>
</template>

<script>
// Import function call api
import { getListCourse, postCreateCourse, putUpdateCourse, deleteCourse } from '@/api/manage-course';

// Import Component
import LazyLoad from '@/components/LazyLoad';

// Import function helper
import { handleNextPage } from '@/utils/lazyload';
import { IsEmptyOrWhiteSpace } from '@/utils/validate';

// Import Toast
import { MakeToast } from '@/utils/toast_message';

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
        course_id: '',
        course_name: '',
      },

      // index Edit
      isIndexEdit: '',
    };
  },
  methods: {
    // Get List Course
    handleGetListCourse() {
      let length;
      if (this.isAction === 'CREATE' || this.isAction === '' || this.isAction === 'DELETE') {
        length = this.ListCourse.length;
      } else if (this.isAction === 'EDIT') {
        length = this.isIndexEdit;
      }

      this.page = handleNextPage(length);

      const param = {
        page: this.page,
      };

      getListCourse(param)
        .then((response) => {
          if (this.page > 1) {
            this.ListCourse = [...this.ListCourse, ...response.data];
          } else {
            this.ListCourse = [...response.data];
          }

          this.ListCourse = [...new Map(this.ListCourse.map(item => [item['course_id'], item])).values()];
          this.overlay.show = false;
        });
    },

    // Handle Open Modal
    handleOpenModal(course, index) {
      this.showModal = true;
      this.isResetDataModal();

      if (course !== null) {
        this.Course.course_id = course.course_id;
        this.Course.course_name = course.course_name;
        this.isIndexEdit = index;

        this.isAction = 'EDIT';
      } else {
        this.isAction = 'CREATE';
      }
    },

    // Handle Reset Data in Modal
    isResetDataModal() {
      const COURSE = {
        course_id: '',
        course_name: '',
      };

      this.Course = COURSE;
    },

    // Handle Create Course
    handleCreateCourse() {
      const COURSE_NAME = this.Course.course_name;

      const COURSE = {
        'course_name': COURSE_NAME,
      };

      const isValidCourse = this.isValidateCourse(COURSE);

      if (isValidCourse.status === true) {
        postCreateCourse(COURSE)
          .then(() => {
            MakeToast({
              variant: 'success',
              title: this.$t('views.manage-course.message.success'),
              content: this.$t('views.manage-course.message.message-create-success'),
              toaster: 'b-toaster-top-right',
            });

            this.isResetDataModal();
            this.showModal = false;
            this.overlay.show = true;
            this.handleGetListCourse();
            this.overlay.show = false;
          });
      } else {
        MakeToast({
          variant: 'warning',
          title: this.$t('views.manage-course.valid.title'),
          content: this.$t(isValidCourse.type),
          toaster: 'b-toaster-top-right',
        });
      }
    },

    // Handler Update Courser
    handleUpdateCourse() {
      const COURSE_ID = this.Course.course_id;
      const COURSE_NAME = this.Course.course_name;

      const COURSE = {
        'course_name': COURSE_NAME,
      };

      const ID = {
        'id': COURSE_ID,
      };

      const isValidCourse = this.isValidateCourse(COURSE);

      if (isValidCourse.status === true) {
        putUpdateCourse(COURSE, ID)
          .then(() => {
            MakeToast({
              variant: 'success',
              title: this.$t('views.manage-course.message.success'),
              content: this.$t('views.manage-course.message.message-edit-success'),
              toaster: 'b-toaster-top-right',
            });

            this.showModal = false;
            this.page = 1;
            this.overlay.show = true;
            this.handleGetListCourse();
            this.overlay.show = false;
          });
      } else {
        MakeToast({
          variant: 'warning',
          title: this.$t('views.manage-course.valid.title'),
          content: this.$t(isValidCourse.type),
          toaster: 'b-toaster-top-right',
        });
      }
    },

    // Handle Delete Course
    handleDeleteCourse(id) {
      this.isAction = 'DELETE';

      const ID = {
        'course_id': id,
      };

      deleteCourse(ID)
        .then(() => {
          MakeToast({
            variant: 'success',
            title: this.$t('views.manage-course.message.success'),
            content: this.$t('views.manage-course.message.message-delete-success'),
            toaster: 'b-toaster-top-right',
          });

          this.showModal = false;
          this.ListCourse.length = this.ListCourse.length - 1;
          this.overlay.show = true;
          this.handleGetListCourse();
          this.overlay.show = false;
        });
    },

    isValidateCourse(course) {
      let isPass = {
        status: false,
        type: '',
      };

      const checkCourseName = IsEmptyOrWhiteSpace(course.course_name);

      if (checkCourseName === true) {
        isPass = {
          status: false,
          type: 'views.manage-course.valid.course_name',
        };
      } else {
        isPass = {
          status: true,
          type: -1,
        };
      }

      return isPass;
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
