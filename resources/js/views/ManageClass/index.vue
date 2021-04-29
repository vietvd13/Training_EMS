<template>
  <div style="margin-top: 20px">
    <div class="zone-header-page">
      <b-row>
        <b-col sm="4">
          <div class="zone-controls">
            <b-button @click="handleOpenModal(null)">{{ $t('views.manage-class.create-new') }}</b-button>
          </div>
        </b-col>
        <b-col sm="5" />
        <b-col sm="3">
          <div class="zone-controls">
            <b-form-input v-model="keySearch" :placeholder="$t('views.manage-class.enter-search')" />
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
                  <b-tr>
                    <b-th>
                      <span>{{ $t('views.manage-class.table.no') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.manage-class.table.id') }}</span>
                    </b-th>

                    <b-th class="zone-min-width">
                      <span>{{ $t('views.manage-class.table.class-name') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.manage-class.table.actions') }}</span>
                    </b-th>
                  </b-tr>
                </b-thead>

                <b-tbody>
                  <b-tr
                    v-for="(currentClass, indexClass) in ListClass"
                    :key="indexClass"
                  >
                    <b-td>
                      <span>{{ indexClass + 1 }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ currentClass.class_id }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ currentClass.class_name }}</span>
                    </b-td>

                    <b-td class="zone-button-control">
                      <div class="zone-button-edit">
                        <b-button @click="handleOpenModal(currentClass.class_id)">
                          {{ $t('views.manage-class.table.edit') }}
                        </b-button>
                      </div>

                      <div class="zone-button-delete">
                        <b-button @click="handleDeleteClass(currentClass.class_id)">
                          {{ $t('views.manage-class.table.delete') }}
                        </b-button>
                      </div>
                    </b-td>
                  </b-tr>

                  <LazyLoad @lazyload="handleGetListClass()" />
                </b-tbody>
              </b-table-simple>
            </div>
          </b-overlay>
        </div>
      </div>
    </div>

    <b-modal
      id="modal-class"
      v-model="showModal"
      size="lg"
      centered
      :title="isAction === 'CREATE' ? $t('views.manage-class.modal.title-create') : $t('views.manage-user.modal.title-edit')"
    >
      <b-form-group
        label-cols="4"
        label-cols-lg="2"
        :label="$t('views.manage-class.modal.class-name')"
        label-for="input-classname"
      >
        <b-form-input
          id="input-classname"
          v-model="isClass.class_name"
          :placeholder="$t('views.manage-class.modal.enter-class-name')"
        />
      </b-form-group>

      <div style="margin-top: 20px;">
        <b-row>
          <b-col sm="5" class="zone-diplay-title-list">
            <span>{{ $t('views.manage-class.modal.all-course') }}</span>
          </b-col>

          <b-col sm="2" />

          <b-col sm="5" class="zone-diplay-title-list">
            <span>{{ $t('views.manage-class.modal.course-in-class') }}</span>
          </b-col>
        </b-row>
      </div>

      <div>
        <b-row>
          <b-col sm="5" style="padding: 0;">
            <div class="zone-display-list">
              <draggable class="list-group" :list="ListCourse" group="course">
                <div
                  v-for="(course, indexCourse) in ListCourse"
                  :key="indexCourse"
                  class="zone-display-item"
                >
                  <span>{{ course.course_name }}</span>
                </div>
              </draggable>
            </div>
          </b-col>

          <b-col sm="2" />

          <b-col sm="5" style="padding: 0;">
            <div class="zone-display-list">
              <draggable class="list-group" :list="isClass.class_courses" group="course">
                <div
                  v-for="(courseSelect, indexCourseSelect) in isClass.class_courses"
                  :key="indexCourseSelect"
                  class="zone-display-item"
                >
                  <span>{{ courseSelect.course_name }}</span>
                </div>
              </draggable>
            </div>
          </b-col>
        </b-row>
      </div>

      <div style="margin-top: 20px;">
        <b-row>
          <b-col sm="5" class="zone-diplay-title-list">
            <span>{{ $t('views.manage-class.modal.all-student') }}</span>
          </b-col>

          <b-col sm="2" />

          <b-col sm="5" class="zone-diplay-title-list">
            <span>{{ $t('views.manage-class.modal.student-in-class') }}</span>
          </b-col>
        </b-row>
      </div>

      <div>
        <b-row>
          <b-col sm="5" style="padding: 0;">
            <div class="zone-display-list">
              <draggable class="list-group" :list="ListTrainee" group="trainee">
                <div
                  v-for="(trainee, indexTrainee) in ListTrainee"
                  :key="indexTrainee"
                  class="zone-display-item"
                >
                  <span>{{ trainee.trainee_name }}</span>
                </div>
              </draggable>
            </div>
          </b-col>

          <b-col sm="2" />

          <b-col sm="5" style="padding: 0;">
            <div class="zone-display-list">
              <draggable class="list-group" :list="isClass.class_trainee" group="trainee">
                <div
                  v-for="(trainee_select, indexTraineeSelect) in isClass.class_trainee"
                  :key="indexTraineeSelect"
                  class="zone-display-item"
                >
                  <span>{{ trainee_select.trainee_name }}</span>
                </div>
              </draggable>
            </div>
          </b-col>
        </b-row>
      </div>
      <template #modal-footer>
        <div>
          <b-button
            v-if="isAction === 'CREATE'"
            @click="handleCreateClass()"
          >
            {{ $t('views.manage-user.modal.create') }}
          </b-button>

          <b-button
            v-if="isAction === 'EDIT'"
            @click="handleUpdateClass()"
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
// Import component
import draggable from 'vuedraggable';

// Import function call api
import { getListCourse, getListTrainee, getListClass, postCreateClass, getOneClass, putUpdateClass, deleteClass } from '@/api/manage-class';

// Import Component
import LazyLoad from '@/components/LazyLoad';

// Import function helper
import { handleNextPage } from '@/utils/lazyload';
import { getKey, reNameKey } from '@/utils/getKey';
import { removeDupEl } from '@/utils/helperDrag';
import { IsEmptyOrWhiteSpace } from '@/utils/validate';

// Import Toast
import { MakeToast } from '@/utils/toast_message';

export default {
  name: 'ManageClass',
  components: {
    draggable,
    LazyLoad,
  },
  data() {
    return {
      // Key Search
      keySearch: '',

      // Overlay
      overlay: {
        show: true,
        variant: 'light',
        opacity: 1,
        blur: '1rem',
        rounded: 'sm',
      },

      // List class
      ListClass: [],

      // Modal
      showModal: false,

      // Class
      isClass: {
        class_id: '',
        class_name: '',
        class_courses: [],
        class_trainee: [],
      },

      // Data
      ListCourse: [],
      ListTrainee: [],

      // Action
      isAction: '',

      // Index
      isIndexEdit: '',

      // Page
      page: 1,
    };
  },
  methods: {
    // Get List Course
    async handleGetListCourse() {
      const PARAM = {
        full: 1,
      };

      await getListCourse(PARAM)
        .then((response) => {
          this.ListCourse = reNameKey(response, 'id', 'courese_id');
        });
    },

    // Get List Trainee
    async handleGetListTrainee() {
      await getListTrainee()
        .then((response) => {
          this.ListTrainee = reNameKey(response, 'id', 'trainee_id');
          this.ListTrainee = reNameKey(response, 'name', 'trainee_name');
        });
    },

    // Get List Class
    handleGetListClass() {
      let length;

      if (this.isAction === 'CREATE' || this.isAction === '' || this.isAction === 'DELETE') {
        length = this.ListClass.length;
      } else if (this.isAction === 'EDIT') {
        length = this.isIndexEdit;
      }

      this.page = handleNextPage(length);

      const PARAM = {
        page: this.page,
      };

      getListClass(PARAM)
        .then((response) => {
          if (this.page > 1) {
            this.ListClass = [...this.ListClass, ...response.data];
          } else {
            this.ListClass = [...response.data];
          }

          this.ListClass = [...new Map(this.ListClass.map(item => [item['class_id'], item])).values()];
          this.overlay.show = false;
        });
    },

    // Handle Open Modal
    async handleOpenModal(id) {
      this.isResetDataModal();
      this.handleGetListCourse();
      this.handleGetListTrainee();

      if (id !== null) {
        this.isAction = 'EDIT';

        const ID = {
          id: id,
        };

        await getOneClass(ID)
          .then((response) => {
            this.isClass.class_id = response.data.class_id;
            this.isClass.class_name = response.data.class_name;
            this.isClass.class_courses = response.data.class_course;
            this.isClass.class_trainee = response.data.class_trainees;
          });
      } else {
        this.isAction = 'CREATE';
      }

      this.ListCourse = removeDupEl(this.ListCourse, this.isClass.class_courses, 'courese_id');

      this.ListTrainee = removeDupEl(this.ListTrainee, this.isClass.class_trainee, 'trainee_id');

      this.showModal = true;
    },

    // Handle Create Class
    handleCreateClass() {
      const list_course = getKey(this.isClass.class_courses, 'courese_id');
      const list_trainee = getKey(this.isClass.class_trainee, 'trainee_id');

      const NEW_CLASS = {
        'class_name': this.isClass.class_name,
        'class_courses': list_course,
        'class_students': list_trainee,
      };

      const isValidateClass = this.isValidateClass(NEW_CLASS);

      if (isValidateClass.status === true) {
        postCreateClass(NEW_CLASS)
          .then(() => {
            MakeToast({
              variant: 'success',
              title: this.$t('views.manage-class.message.success'),
              content: this.$t('views.manage-class.message.message-create-success'),
              toaster: 'b-toaster-top-right',
            });

            this.isResetDataModal();
            this.showModal = false;
            this.overlay.show = true;
            this.handleGetListClass();
            this.overlay.show = false;
          });
      } else {
        const TITLE = 'views.manage-class.valid.title';

        MakeToast({
          variant: 'warning',
          title: this.$t(TITLE),
          content: this.$t(isValidateClass.type),
          toaster: 'b-toaster-top-right',

        });
      }
    },

    // Handle Update Class
    handleUpdateClass() {
      const list_course = getKey(this.isClass.class_courses, 'courese_id');
      const list_trainee = getKey(this.isClass.class_trainee, 'trainee_id');

      const UPDATE_CLASS = {
        'class_name': this.isClass.class_name,
        'class_courses': list_course,
        'class_students': list_trainee,
      };

      const ID_UPDATE = {
        'id': this.isClass.class_id,
      };

      const isValidateClass = this.isValidateClass(UPDATE_CLASS);

      if (isValidateClass.status === true) {
        putUpdateClass(UPDATE_CLASS, ID_UPDATE)
          .then(() => {
            MakeToast({
              variant: 'success',
              title: this.$t('views.manage-class.message.success'),
              content: this.$t('views.manage-class.message.message-edit-success'),
              toaster: 'b-toaster-top-right',
            });

            this.showModal = false;
            this.page = 1;
            this.overlay.show = true;
            this.handleGetListClass();
            this.overlay.show = false;
          });
      } else {
        const TITLE = 'views.manage-class.valid.title';

        MakeToast({
          variant: 'warning',
          title: this.$t(TITLE),
          content: this.$t(isValidateClass.type),
          toaster: 'b-toaster-top-right',

        });
      }
    },

    // Handle Delete Class
    handleDeleteClass(id) {
      this.isAction = 'DELETE';

      const PARAM = {
        id: id,
      };

      this.$bvModal.msgBoxConfirm(this.$t('views.manage-user.confirm.cf-delete'), {
        title: this.$t('views.manage-user.confirm.title'),
        size: 'sm',
        buttonSize: 'sm',
        okVariant: 'danger',
        okTitle: this.$t('views.manage-user.confirm.cf-yes'),
        cancelTitle: this.$t('views.manage-user.confirm.cf-no'),
        footerClass: 'p-2',
        hideHeaderClose: false,
        centered: true,
      })
        .then(value => {
          if (value === true) {
            deleteClass(PARAM)
              .then((response) => {
                if (response.message !== 'Can not delete because relationship') {
                  MakeToast({
                    variant: 'success',
                    title: this.$t('views.manage-class.message.success'),
                    content: this.$t('views.manage-class.message.message-delete-success'),
                    toaster: 'b-toaster-top-right',
                  });

                  this.showModal = false;
                  this.ListClass.length = this.ListClass.length - 1;
                  this.overlay.show = true;
                  this.handleGetListClass();
                  this.overlay.show = false;
                } else {
                  MakeToast({
                    variant: 'warning',
                    title: this.$t('views.manage-class.message.warning'),
                    content: this.$t('views.manage-class.message.message-delete-relationship'),
                    toaster: 'b-toaster-top-right',
                  });
                }
              });
          }
        })
        .catch(err => {
          console.log(err);
        });
    },

    isResetDataModal() {
      const IS_CLASS = {
        class_id: '',
        class_name: '',
        class_courses: [],
        class_trainee: [],
      };

      this.isClass = IS_CLASS;
    },

    isValidateClass(currentClass) {
      let isValid = {
        status: false,
        type: '',
      };

      const isCheckName = IsEmptyOrWhiteSpace(currentClass.class_name);

      if (isCheckName === true) {
        isValid = {
          status: false,
          type: 'views.manage-class.valid.class-name',
        };
      } else {
        isValid = {
          status: true,
          type: -1,
        };
      }

      return isValid;
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

  .zone-display-list {
    width: 100%;
    height: 250px;
    background-color: #dddddd;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    overflow-y: scroll;
    padding: 5px;
    border: solid 2px #052c50;

    .list-group {
      width: 100%;
      height: 100%;

      .zone-display-item {
        margin-top: 5px;
        margin-bottom: 5px;

        span {
          width: 100%;
          height: 100%;
          background-color: #fff;
          color: #303133;
          margin: 0 auto;
          display: flex;
          justify-content: center;
          align-items: center;
          padding: 5px;
          border-radius: 5px;
          font-weight: 400;

          &:active {
            background-color: #ffe268;
            opacity: 0.7;
          }
        }

        &:hover {
          cursor: grab;
        }
      }
    }
  }

  .zone-diplay-title-list {
    width: 100%;
    padding-top: 10px;
    padding-bottom: 10px;
    background-color: #052c50;
    color: #fff;
    font-weight: 600;
    text-align: center;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
  }
</style>
