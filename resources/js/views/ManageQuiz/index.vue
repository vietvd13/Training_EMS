<template>
  <div style="margin-top: 20px;">
    <div class="zone-header-page">
      <b-row>
        <b-col sm="4">
          <div class="zone-controls">
            <b-button @click="handleOpenModal(null)">{{ $t('views.manage-quiz.create-new') }}</b-button>
          </div>
        </b-col>

        <b-col sm="5" />

        <b-col sm="3">
          <b-form-input v-model="keySearch" :placeholder="$t('views.manage-quiz.enter-search')" />
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
                      <span>{{ $t('views.manage-quiz.table.no') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.manage-quiz.table.id') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.manage-quiz.table.quiz') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.manage-quiz.table.actions') }}</span>
                    </b-th>
                  </b-tr>
                </b-thead>

                <b-tbody>
                  <b-tr
                    v-for="(quiz, indexQuiz) in ListQuiz"
                    :key="indexQuiz"
                  >
                    <b-td>
                      <span>{{ indexQuiz + 1 }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ quiz.id }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ quiz.question_content }}</span>
                    </b-td>

                    <b-td class="zone-button-control">
                      <div class="zone-button-edit">
                        <b-button @click="handleOpenModal(quiz)">{{ $t('views.manage-quiz.table.edit') }}</b-button>
                      </div>

                      <div class="zone-button-delete">
                        <b-button @click="handleDeleteQuiz(quiz)">{{ $t('views.manage-quiz.table.delete') }}</b-button>
                      </div>
                    </b-td>
                  </b-tr>

                  <LazyLoad @lazyload="handleGetListQuiz()" />
                </b-tbody>
              </b-table-simple>
            </div>
          </b-overlay>
        </div>
      </div>
    </div>

    <b-modal
      id="modal-quiz"
      v-model="showModal"
      size="lg"
      centered
      :title="isAction === 'CREATE' ? $t('views.manage-quiz.modal.title-create') : $t('views.manage-quiz.modal.title-edit')"
    >
      <b-form-group
        label-cols="4"
        label-cols-lg="2"
        :label="$t('views.manage-quiz.modal.quiz-content')"
        label-for="input-quiz-content"
      >
        <b-form-textarea
          id="input-quiz-content"
          v-model="Quiz.question_content"
          :placeholder="$t('views.manage-quiz.modal.enter-quiz-content')"
          rows="4"
          max-rows="6"
        />
      </b-form-group>

      <div class="zone-table-answer">
        <b-table-simple
          :bordered="true"
          :outlined="false"
          :fixed="false"
        >
          <b-thead>
            <b-tr>
              <b-th class="zone-min-width">
                <span>{{ $t('views.manage-quiz.modal.table.is-correct') }}</span>
              </b-th>

              <b-th>
                <span>{{ $t('views.manage-quiz.modal.table.answer-content') }}</span>
              </b-th>

              <b-th class="zone-min-width">
                <span>{{ $t('views.manage-quiz.modal.table.action') }}</span>
              </b-th>
            </b-tr>
          </b-thead>

          <b-tbody>
            <b-tr
              v-for="(answer, indexAnswer) in Quiz.question_answers"
              :key="indexAnswer"
            >
              <b-td class="zone-min-width">
                <b-form-checkbox v-model="answer.is_correct" size="lg" />
              </b-td>

              <b-td>
                <b-form-input v-model="answer.answer_content" :placeholder="$t('views.manage-quiz.modal.table.enter-answer-content')" />
              </b-td>

              <b-td class="zone-min-width">
                <b-button @click="handleDeleteAnswer(indexAnswer)">
                  {{ $t('views.manage-quiz.modal.table.delete') }}
                </b-button>
              </b-td>
            </b-tr>
          </b-tbody>
        </b-table-simple>
      </div>

      <div class="zone-add-quiz">
        <div @click="handleAddAnswer()">+</div>
      </div>

      <template #modal-footer>
        <div>
          <b-button
            v-if="isAction === 'CREATE'"
            @click="handleCreateQuiz()"
          >
            {{ $t('views.manage-user.modal.create') }}
          </b-button>

          <b-button
            v-if="isAction === 'EDIT'"
            @click="handleUpdateQuiz()"
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
import { getListQuiz, postCreateQuiz, putUpdateQuiz, deleteQuiz } from '@/api/manage-quiz';

// Import component
import LazyLoad from '@/components/LazyLoad';

// Import function helper
import { handleNextPage } from '@/utils/lazyload';
import { changeBoolean2Number, isCountDup, changeNumber2Boolean } from '@/utils/deCode';
import { IsEmptyOrWhiteSpace } from '@/utils/validate';

// Import Toast
import { MakeToast } from '@/utils/toast_message';

export default {
  name: 'ManageQuiz',
  components: {
    LazyLoad,
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

      // Data
      ListQuiz: [],

      // Action
      isAction: '',

      // Index Edit
      isIndexEdit: '',

      // Page
      page: '',

      // Show Modal
      showModal: false,

      // Quiz
      Quiz: {
        id: '',
        question_content: '',
        question_answers: [
          {
            answer_content: '',
            is_correct: false,
          },
        ],
        is_multiple_choice: 0,
      },
    };
  },
  methods: {
    handleGetListQuiz() {
      let length;

      if (this.isAction === 'CREATE' || this.isAction === '' || this.isAction === 'DELETE') {
        length = this.ListQuiz.length;
      } else if (this.isAction === 'EDIT') {
        length = this.isIndexEdit;
      }

      this.page = handleNextPage(length);

      const PARAM = {
        page: this.page,
      };

      getListQuiz(PARAM)
        .then((response) => {
          if (this.page > 1) {
            this.ListQuiz = [...this.ListQuiz, ...response.data];
          } else {
            this.ListQuiz = [...response.data];
          }

          this.ListQuiz = [...new Map(this.ListQuiz.map(item => [item['id'], item])).values()];
          this.overlay.show = false;
        });
    },

    // handle Open Modal
    handleOpenModal(quiz) {
      this.isResetDataModal();

      if (quiz !== null) {
        this.isAction = 'EDIT';
        this.Quiz.id = quiz.id;
        this.Quiz.question_content = quiz.question_content;
        const list_answer = JSON.parse(JSON.stringify(quiz.answer));
        this.Quiz.question_answers = changeNumber2Boolean(list_answer, 'is_correct');
      } else {
        this.isAction = 'CREATE';
      }

      this.showModal = true;
    },

    // handle add answer
    handleAddAnswer() {
      const ANSWER = {
        answer_content: '',
        is_correct: false,
      };

      this.Quiz.question_answers.push(ANSWER);
    },

    // handle delete answer
    handleDeleteAnswer(index) {
      this.Quiz.question_answers.splice(index, 1);
    },

    // handle create new question
    async handleCreateQuiz() {
      const question_content = this.Quiz.question_content;
      let list_answer = JSON.parse(JSON.stringify(this.Quiz.question_answers));
      list_answer = changeBoolean2Number(list_answer, 'is_correct');
      const countCorrect = isCountDup(list_answer, 'is_correct', 1);
      const is_multiple_choice = countCorrect > 1 ? 1 : 0;

      const NEW_QUIZ = {
        'question_content': question_content,
        'question_answers': list_answer,
        'is_multiple_choice': is_multiple_choice,
      };

      const isValid = this.isValidQuiz(NEW_QUIZ);

      if (isValid.status === true) {
        await postCreateQuiz(NEW_QUIZ)
          .then(() => {
            MakeToast({
              variant: 'success',
              title: this.$t('views.manage-quiz.message.success'),
              content: this.$t('views.manage-quiz.message.message-create-success'),
              toaster: 'b-toaster-top-right',
            });

            this.isResetDataModal();
            this.showModal = false;
            this.overlay.show = true;
            this.handleGetListQuiz();
            this.overlay.show = false;
          });
      } else {
        const TITLE = 'views.manage-quiz.valid.title';

        MakeToast({
          variant: 'warning',
          title: this.$t(TITLE),
          content: this.$t(isValid.type),
          toaster: 'b-toaster-top-right',
        });
      }
    },

    // handle update a question
    async handleUpdateQuiz() {
      const question_content = this.Quiz.question_content;
      let list_answer = JSON.parse(JSON.stringify(this.Quiz.question_answers));
      list_answer = changeBoolean2Number(list_answer, 'is_correct');
      const countCorrect = isCountDup(list_answer, 'is_correct', 1);
      const is_multiple_choice = countCorrect > 1 ? 1 : 0;

      const UPDATE_QUIZ = {
        'question_content': question_content,
        'question_answers': list_answer,
        'is_multiple_choice': is_multiple_choice,
      };

      const ID = {
        'id': this.Quiz.id,
      };

      const isValid = this.isValidQuiz(UPDATE_QUIZ);

      if (isValid.status === true) {
        await putUpdateQuiz(UPDATE_QUIZ, ID)
          .then(() => {
            MakeToast({
              variant: 'success',
              title: this.$t('views.manage-quiz.message.success'),
              content: this.$t('views.manage-quiz.message.message-edit-success'),
              toaster: 'b-toaster-top-right',
            });

            this.showModal = false;
            this.overlay.show = true;
            this.handleGetListQuiz();
            this.overlay.show = false;
          });
      } else {
        const TITLE = 'views.manage-quiz.valid.title';

        MakeToast({
          variant: 'warning',
          title: this.$t(TITLE),
          content: this.$t(isValid.type),
          toaster: 'b-toaster-top-right',
        });
      }
    },

    // Handle Delete Quiz
    handleDeleteQuiz(quiz) {
      this.isAction = 'DELETE';

      const ID = {
        'id': quiz.id,
      };

      this.$bvModal.msgBoxConfirm(this.$t('views.manage-quiz.confirm.cf-delete'), {
        title: this.$t('views.manage-quiz.confirm.title'),
        size: 'sm',
        buttonSize: 'sm',
        okVariant: 'danger',
        okTitle: this.$t('views.manage-quiz.confirm.cf-yes'),
        cancelTitle: this.$t('views.manage-quiz.confirm.cf-no'),
        footerClass: 'p-2',
        hideHeaderClose: false,
        centered: true,
      })
        .then(value => {
          if (value === true) {
            deleteQuiz(ID)
              .then((response) => {
                if (response.message !== 'can not delete because relationship') {
                  MakeToast({
                    variant: 'success',
                    title: this.$t('views.manage-quiz.message.success'),
                    content: this.$t('views.manage-quiz.message.message-delete-success'),
                    toaster: 'b-toaster-top-right',
                  });

                  this.showModal = false;
                  this.ListQuiz.length = this.ListQuiz.length - 1;
                  this.overlay.show = true;
                  this.handleGetListQuiz();
                  this.overlay.show = false;
                } else {
                  MakeToast({
                    variant: 'warning',
                    title: this.$t('views.manage-quiz.message.warning'),
                    content: this.$t('views.manage-quiz.message.message-delete-relationship'),
                    toaster: 'b-toaster-top-right',
                  });
                }
              });
          }
        });
    },

    // Handle Reset Data in Modal
    isResetDataModal() {
      const QUIZ = {
        id: '',
        question_content: '',
        question_answers: [
          {
            answer_content: '',
            is_correct: false,
          },
        ],
        is_multiple_choice: 0,
      };

      this.Quiz = QUIZ;
    },

    // Validation Quiz
    isValidQuiz(quiz) {
      let isValid = {
        status: false,
        type: '',
      };

      const isCheckQuizContent = IsEmptyOrWhiteSpace(quiz.question_content);
      const isCheckLengthAnswer = quiz.question_answers.length > 0;
      const isCheckAnswerContentEmpty = this.isCheckValEmptyInList(quiz.question_answers, 'answer_content');

      if (isCheckQuizContent === true) {
        isValid = {
          status: false,
          type: 'views.manage-quiz.valid.quiz-content',
        };

        return isValid;
      } else if (isCheckLengthAnswer === false) {
        isValid = {
          status: false,
          type: 'views.manage-quiz.valid.answer-limit',
        };

        return isValid;
      } else if (isCheckAnswerContentEmpty === true) {
        isValid = {
          status: false,
          type: 'views.manage-quiz.valid.answer-empty',
        };

        return isValid;
      } else {
        isValid = {
          status: true,
          type: -1,
        };

        return isValid;
      }
    },

    isCheckValEmptyInList(arr, key) {
      const length = arr.length;
      let index = 0;

      for (index; index < length; index++) {
        if (IsEmptyOrWhiteSpace(arr[index][key])) {
          return true;
        }
      }

      return false;
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
