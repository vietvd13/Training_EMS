<template>
  <div style="margin-top: 20px;">
    <!-- Title Test -->
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="zone-respondent-title-test">
              <span>{{ isTest.test_name }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Question Title -->
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="zone-respondent-question-test">
              <span>{{ isQuestion.question_content }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="zone-respondent-answers-test">
              <b-form-group style="margin: 10px">
                <b-form-checkbox-group
                  v-for="(answer, indexAnswer) in isQuestion.answer"
                  :key="indexAnswer"
                  v-model="isAnswerSelectd"
                  size="lg"
                >
                  <b-form-checkbox :value="answer.id"><span>{{ answer.answer_content }}</span></b-form-checkbox>
                </b-form-checkbox-group>
              </b-form-group>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Submit -->
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="zone-respondent-submit-test">
              <b-button id="btn-submit-test" @click="handleNextQuestion()">Submit</b-button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
// Import function call api
import { getOnTest, postSubmitTest } from '@/api/do-test';

export default {
  name: 'DoTest',
  data() {
    return {
      isTest: {
        test_class: '',
        test_course: '',
        test_id: '',
        test_name: '',
        test_questions: [],
      },

      indexQuestion: 0,

      isQuestion: {
        id: '',
        question_content: '',
        is_multiple_choice: '',
        number_of_answer: '',
        answer: [],
      },

      isAnswerSelectd: [],

      ListAnswer: [],
    };
  },
  created() {
    this.handleGetOneTest();
  },
  methods: {
    async handleGetOneTest() {
      const GET_ID_TEST = 1; // this.$store.getters.respondent.selected.id_test
      if (GET_ID_TEST !== null) {
        const ID_TEST = {
          'id': GET_ID_TEST,
        };

        await getOnTest(ID_TEST)
          .then((response) => {
            this.isTest = response.data;
            this.handleDisplayQuestion(this.indexQuestion);
          });
      } else {
        this.$router.push({ path: '/choose-test', query: this.otherQuery }, onAbort => {});
      }
    },

    async handleSubmitTest() {
      const DATA_SUBMIT = {
        'test_id': 1, // this.$store.getters.respondent.selected.id_test,
        'answers': this.ListAnswer,
      };

      await postSubmitTest(DATA_SUBMIT)
        .then((response) => {
          console.log(response);
        });
    },

    handleNextQuestion() {
      const NUM_OF_QUESTION = this.isTest.test_questions.length;

      if (this.indexQuestion >= 0 && this.indexQuestion < NUM_OF_QUESTION - 1) {
        this.handleStoreAnswer(this.isQuestion.id, this.isAnswerSelectd);
        this.indexQuestion = this.indexQuestion + 1;
        this.handleDisplayQuestion(this.indexQuestion);
      } else {
        this.handleStoreAnswer(this.isQuestion.id, this.isAnswerSelectd);
        this.handleSubmitTest();
        this.$router.push({ path: '/complete-test', query: this.otherQuery }, onAbort => {});
      }

      this.isAnswerSelectd = [];
    },

    handleDisplayQuestion(index) {
      const currentQuestion = this.isTest.test_questions[index];

      this.isQuestion.id = currentQuestion.id;
      this.isQuestion.question_content = currentQuestion.question_content;
      this.isQuestion.is_multiple_choice = currentQuestion.is_multiple_choice;
      this.isQuestion.number_of_answer = currentQuestion.number_of_answer;
      this.isQuestion.answer = currentQuestion.answer;
    },

    handleStoreAnswer(question_id, answer) {
      const ANSWER = {
        question_id: question_id,
        answer: answer,
      };

      this.ListAnswer.push(ANSWER);
    },
  },
};
</script>

<style lang="scss" scoped>
  .zone-respondent-title-test {
    text-align: center;
    font-size: 20px;
  }

  .zone-respondent-question-test {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    height: 600px;
    overflow-y: auto;
  }

  .zone-respondent-answers-test {
    display: flex;
    align-items: center;
    height: 600px;
    overflow-y: auto;
  }

  .zone-respondent-submit-test {
    text-align: center;

    button#btn-submit-test {
      width: 100%;
      background-color: #fb8c00;
      border: none;

      &:hover {
        opacity: 0.7;
      }

      &:focus {
        background-color: #fb8c00;
      }
    }
  }
</style>
