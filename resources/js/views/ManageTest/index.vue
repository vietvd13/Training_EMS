<template>
  <div style="margin-top: 20px;">
    <div class="zone-header-page">
      <b-row>
        <b-col sm="4">
          <div class="zone-controls">
            <b-button @click="handleOpenModal(null)">{{ $t('views.manage-test.create-new') }}</b-button>
          </div>
        </b-col>

        <b-col sm="5" />

        <b-col sm="3">
          <b-form-input v-model="keySearch" :placeholder="$t('views.manage-test.enter-search')" />
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
                      <span>{{ $t('views.manage-test.table.no') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.manage-test.table.id') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.manage-test.table.test') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.manage-test.table.actions') }}</span>
                    </b-th>
                  </b-tr>
                </b-thead>

                <b-tbody>
                  <b-tr
                    v-for="(test, indexTest) in ListTest"
                    :key="indexTest"
                  >
                    <b-td>
                      <span>{{ indexTest + 1 }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ test.test_id }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ test.test_name }}</span>
                    </b-td>

                    <b-td class="zone-button-control">
                      <div class="zone-button-edit">
                        <b-button @click="handleOpenModal(test)">{{ $t('views.manage-quiz.table.edit') }}</b-button>
                      </div>

                      <div class="zone-button-delete">
                        <b-button @click="handleDeleteTest(test.test_id)">{{ $t('views.manage-quiz.table.delete') }}</b-button>
                      </div>
                    </b-td>
                  </b-tr>

                  <LazyLoad @lazyload="handleGetListTest()" />
                </b-tbody>
              </b-table-simple>
            </div>
          </b-overlay>
        </div>
      </div>
    </div>

    <b-modal
      id="modal-test"
      v-model="showModal"
      size="lg"
      centered
      :title="isAction === 'CREATE' ? $t('views.manage-test.modal.title-create') : $t('views.manage-test.modal.title-edit')"
    >
      <b-form-group
        label-cols="4"
        label-cols-lg="2"
        :label="$t('views.manage-test.modal.test_name')"
        label-for="input-test_name"
      >
        <b-form-input
          id="input-test_name"
          v-model="isTest.test_name"
          :placeholder="$t('views.manage-test.modal.enter-test_name')"
        />
      </b-form-group>

      <b-form-group
        label-cols="4"
        label-cols-lg="2"
        :label="$t('views.manage-test.modal.select_class')"
        label-for="input-select_class"
      >
        <b-form-select v-model="isTest.test_class" class="mb-3">
          <b-form-select-option :value="null">{{ $t('select.please_select') }}</b-form-select-option>
          <b-form-select-option
            v-for="(isClass, indexClass) in ListClass"
            :key="indexClass"
            :value="isClass.id"
          >
            {{ isClass.class_name }}
          </b-form-select-option>
        </b-form-select>
      </b-form-group>

      <b-form-group
        label-cols="4"
        label-cols-lg="2"
        :label="$t('views.manage-test.modal.select_course')"
        label-for="input-select_course"
      >
        <b-form-select v-model="isTest.test_course" class="mb-3">
          <b-form-select-option :value="null">{{ $t('select.please_select') }}</b-form-select-option>
          <b-form-select-option
            v-for="(course, indexCourse) in ListCourse"
            :key="indexCourse"
            :value="course.id"
          >
            {{ course.course_name }}
          </b-form-select-option>
        </b-form-select>
      </b-form-group>

      <div style="margin-top: 20px;">
        <b-row>
          <b-col sm="5" class="zone-diplay-title-list">
            <span>{{ $t('views.manage-test.modal.all_quiz') }}</span>
          </b-col>

          <b-col sm="2" />

          <b-col sm="5" class="zone-diplay-title-list">
            <span>{{ $t('views.manage-test.modal.quiz-in-test') }}</span>
          </b-col>
        </b-row>
      </div>

      <div>
        <b-row>
          <b-col sm="5" style="padding: 0;">
            <div class="zone-display-list">
              <draggable class="list-group" :list="ListQuiz" group="question">
                <div
                  v-for="(question, indexQuestion) in ListQuiz"
                  :key="indexQuestion"
                  class="zone-display-item"
                >
                  <span>{{ question.question_content }}</span>
                </div>
              </draggable>
            </div>
          </b-col>

          <b-col sm="2" />

          <b-col sm="5" style="padding: 0;">
            <div class="zone-display-list">
              <draggable class="list-group" :list="isTest.test_questions" group="question">
                <div
                  v-for="(questionSelected, indexQuestionSelected) in isTest.test_questions"
                  :key="indexQuestionSelected"
                  class="zone-display-item"
                >
                  <span>{{ questionSelected.question_content }}</span>
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
            @click="handleCreateTest()"
          >
            {{ $t('views.manage-test.modal.create') }}
          </b-button>

          <b-button
            v-if="isAction === 'EDIT'"
            @click="handleUpdateTest()"
          >
            {{ $t('views.manage-test.modal.save') }}
          </b-button>

          <b-button @click="showModal = false">
            {{ $t('views.manage-test.modal.close') }}
          </b-button>
        </div>
      </template>
    </b-modal>
  </div>
</template>

<script>
// Import component
import LazyLoad from '@/components/LazyLoad';
import draggable from 'vuedraggable';

// Import function helper
import { handleNextPage } from '@/utils/lazyload';
import { getKey } from '@/utils/getKey';
import { removeDupEl } from '@/utils/helperDrag';
import { IsEmptyOrWhiteSpace } from '@/utils/validate';

// Import Toast
import { MakeToast } from '@/utils/toast_message';

// Import function call api
import { getListTest, getListClass, getListCourse, getListQuiz, postCreateTest, putUpdateTest, deleteTest } from '@/api/manage-test';

export default {
  name: 'ManageQuiz',
  components: {
    LazyLoad,
    draggable,
  },
  data() {
    return {
      // Search
      keySearch: '',

      // Overlay
      overlay: {
        show: true,
        variant: 'light',
        opacity: 1,
        blur: '1rem',
        rounded: 'sm',
      },

      // Page
      page: 1,

      // Modal
      showModal: false,

      // Action
      isAction: '',

      // Index Edit
      isIndexEdit: '',

      // Data
      ListTest: [],
      ListClass: [],
      ListCourse: [],
      ListQuiz: [],

      isTest: {
        'test_id': '',
        'test_name': '',
        'test_class': null,
        'test_course': null,
        'test_questions': [],
      },
    };
  },
  computed: {
    isSelectClassChange() {
      return this.isTest.test_class;
    },
  },
  watch: {
    isSelectClassChange() {
      this.isTest.test_course = null;
      this.handelGetListCourse();
    },
  },
  methods: {
    // Handle get list class
    async handleGetListClass() {
      const PARAM = {
        id: this.$store.getters.userId,
      };

      await getListClass(PARAM)
        .then((response) => {
          this.ListClass = response.classes_trainer;

          if (this.ListClass.length === 0) {
            this.isTest.test_class = null;
          }
        });
    },

    async handelGetListCourse() {
      if (this.isTest.test_class !== null) {
        const ID_CLASS = {
          id: this.isTest.test_class,
        };

        const ID_TRAINER = {
          'trainer_id': this.$store.getters.userId,
        };

        await getListCourse(ID_CLASS, ID_TRAINER)
          .then((response) => {
            this.ListCourse = response.course;
          });
      } else {
        this.ListCourse = [];
        this.isTest.test_course = null;
      }
    },

    async handelGetListQuiz() {
      const PARAM = {
        page: 1,
      };

      await getListQuiz(PARAM)
        .then((response) => {
          this.ListQuiz = response;
        });
    },

    async handleGetListTest() {
      let length;

      if (this.isAction === 'CREATE' || this.isAction === '' || this.isAction === 'DELETE') {
        length = this.ListTest.length;
      } else if (this.isAction === 'EDIT') {
        length = this.isIndexEdit;
      }

      this.page = handleNextPage(length);

      const PARAM = {
        page: this.page,
      };

      await getListTest(PARAM)
        .then((response) => {
          if (this.page > 1) {
            this.ListTest = [...this.ListTest, ...response.data];
          } else {
            this.ListTest = [...response.data];
          }

          this.ListTest = [...new Map(this.ListTest.map(item => [item['test_id'], item])).values()];
          this.overlay.show = false;
        });
    },

    // handle Open modal
    async handleOpenModal(test) {
      this.isResetModalTest();
      await this.handleGetListClass();

      if (test !== null) {
        this.isAction = 'EDIT';
        this.isTest.test_id = test.test_id;
        this.isTest.test_name = test.test_name;
        this.isTest.test_class = test.test_class;
        await this.handelGetListCourse();
        await this.handelGetListQuiz();
        this.isTest.test_course = test.test_course;
        this.isTest.test_questions = test.test_questions;
      } else {
        this.isAction = 'CREATE';
        await this.handelGetListCourse();
        await this.handelGetListQuiz();
      }

      this.ListQuiz = removeDupEl(this.ListQuiz, this.isTest.test_questions, 'test_id');

      this.showModal = true;
    },

    // Handle Create Test
    handleCreateTest() {
      const test_name = this.isTest.test_name;
      const class_id = this.isTest.test_class;
      const course_id = this.isTest.test_course;
      const test_questions = getKey(this.isTest.test_questions, 'id');

      const NEW_TEST = {
        'test_name': test_name,
        'test_class': class_id,
        'test_course': course_id,
        'test_questions': test_questions,
      };

      const isValidTest = this.isValidTest(NEW_TEST);

      if (isValidTest.status === true) {
        postCreateTest(NEW_TEST)
          .then(() => {
            MakeToast({
              variant: 'success',
              title: this.$t('views.manage-test.message.success'),
              content: this.$t('views.manage-test.message.message-create-success'),
              toaster: 'b-toaster-top-right',
            });

            this.isResetModalTest();
            this.showModal = false;
            this.overlay.show = true;
            this.handleGetListTest();
            this.overlay.show = false;
          });
      } else {
        const TITLE = 'views.manage-test.valid.title';

        MakeToast({
          variant: 'warning',
          title: this.$t(TITLE),
          content: this.$t(isValidTest.type),
          toaster: 'b-toaster-top-right',

        });
      }
    },

    // Handle Update Test
    handleUpdateTest() {
      const test_name = this.isTest.test_name;
      const class_id = this.isTest.test_class;
      const course_id = this.isTest.test_course;
      const test_questions = getKey(this.isTest.test_questions, 'id');

      const TEST = {
        'test_name': test_name,
        'test_class': class_id,
        'test_course': course_id,
        'test_questions': test_questions,
      };

      const ID = {
        'id': this.isTest.test_id,
      };

      const isValidTest = this.isValidTest(TEST);

      if (isValidTest.status === true) {
        putUpdateTest(TEST, ID)
          .then(() => {
            MakeToast({
              variant: 'success',
              title: this.$t('views.manage-test.message.success'),
              content: this.$t('views.manage-test.message.message-edit-success'),
              toaster: 'b-toaster-top-right',
            });

            this.showModal = false;
            this.overlay.show = true;
            this.handleGetListTest();
            this.overlay.show = false;
          });
      } else {
        const TITLE = 'views.manage-test.valid.title';

        MakeToast({
          variant: 'warning',
          title: this.$t(TITLE),
          content: this.$t(isValidTest.type),
          toaster: 'b-toaster-top-right',

        });
      }
    },

    handleDeleteTest(id) {
      this.isAction = 'DELETE';

      const PARAM = {
        id: id,
      };

      this.$bvModal.msgBoxConfirm(this.$t('views.manage-test.confirm.cf-delete'), {
        title: this.$t('views.manage-test.confirm.title'),
        size: 'sm',
        buttonSize: 'sm',
        okVariant: 'danger',
        okTitle: this.$t('views.manage-test.confirm.cf-yes'),
        cancelTitle: this.$t('views.manage-test.confirm.cf-no'),
        footerClass: 'p-2',
        hideHeaderClose: false,
        centered: true,
      })
        .then(value => {
          if (value === true) {
            deleteTest(PARAM)
              .then((response) => {
                if (response.message !== 'Can not delete because the relation') {
                  MakeToast({
                    variant: 'success',
                    title: this.$t('views.manage-test.message.success'),
                    content: this.$t('views.manage-test.message.message-delete-success'),
                    toaster: 'b-toaster-top-right',
                  });

                  this.showModal = false;
                  this.ListTest.length = this.ListTest.length - 1;
                  this.overlay.show = true;
                  this.handleGetListTest();
                  this.overlay.show = false;
                } else {
                  MakeToast({
                    variant: 'warning',
                    title: this.$t('views.manage-test.message.warning'),
                    content: this.$t('views.manage-test.message.message-delete-relationship'),
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

    isValidTest(test) {
      let isValid = {
        status: false,
        type: '',
      };

      const isCheckName = IsEmptyOrWhiteSpace(test.test_name);

      if (isCheckName === true) {
        isValid = {
          status: false,
          type: 'views.manage-test.valid.test-name',
        };
      } else if (test.test_class === null) {
        isValid = {
          status: false,
          type: 'views.manage-test.valid.req-class',
        };
      } else if (test.test_course === null) {
        isValid = {
          status: false,
          type: 'views.manage-test.valid.req-course',
        };
      } else if (test.test_questions.length === 0) {
        isValid = {
          status: false,
          type: 'views.manage-test.valid.req-test-questions',
        };
      } else {
        isValid = {
          status: true,
          type: -1,
        };
      }

      return isValid;
    },

    isResetModalTest() {
      const IS_TEST = {
        'test_id': '',
        'test_name': '',
        'test_class': null,
        'test_course': null,
        'test_questions': [],
      };

      this.isTest = IS_TEST;
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
