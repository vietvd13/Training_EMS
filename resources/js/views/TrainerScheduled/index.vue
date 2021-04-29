<template>
  <div style="margin-top: 20px;">
    <div class="zone-header-page">
      <b-row>
        <b-col sm="4" />

        <b-col sm="5" />

        <b-col sm="3">
          <div class="zone-controls">
            <b-form-input v-model="keySearch" :placeholder="$t('views.trainer_scheduled.enter-search')" />
          </div>
        </b-col>
      </b-row>
    </div>

    <div class="zone-table" style="margin-top: 20px;">
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
                    <b-th class="zone-min-width">
                      <span>{{ $t('views.trainer_scheduled.table.no') }}</span>
                    </b-th>

                    <b-th class="zone-min-width">
                      <span>{{ $t('views.trainer_scheduled.table.id') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.trainer_scheduled.table.class-name') }}</span>
                    </b-th>

                    <b-th style="max-width: 100px;">
                      <span>{{ $t('views.trainer_scheduled.table.actions') }}</span>
                    </b-th>
                  </b-tr>
                </b-thead>

                <b-tbody>
                  <b-tr
                    v-for="(scheduled, indexSchecduled) in ListScheduled"
                    :key="indexSchecduled"
                  >
                    <b-td>
                      <span>{{ indexSchecduled + 1 }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ scheduled.class_id }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ scheduled.class_name }}</span>
                    </b-td>

                    <b-td class="zone-button-control">
                      <div>
                        <b-button @click="handleOpenModal(scheduled, indexSchecduled)">{{ $t('views.trainer_scheduled.table.assign') }}</b-button>
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
      id="trainer_scheduled"
      v-model="showModal"
      size="lg"
      centered
      :title="$t('views.trainer_scheduled.modal.title')"
    >
      <b-form-group
        label-cols="4"
        label-cols-lg="2"
        :label="$t('views.trainer_scheduled.modal.trainer')"
        label-for="input-classname"
      >
        <b-form-select v-model="isAssign.selectedTrainer" class="mb-3">
          <b-form-select-option :value="null">{{ $t('select.please_select') }}</b-form-select-option>
          <b-form-select-option
            v-for="(trainer, indexTrainer) in ListTrainer"
            :key="indexTrainer"
            :value="trainer.id"
          >
            {{ trainer.name }} - {{ trainer.email }}
          </b-form-select-option>
        </b-form-select>
      </b-form-group>

      <template #modal-footer>
        <div>
          <b-button
            @click="handleAssignTrainer()"
          >
            {{ $t('views.trainer_scheduled.modal.assign') }}
          </b-button>

          <b-button @click="showModal = false">
            {{ $t('views.trainer_scheduled.modal.close') }}
          </b-button>
        </div>
      </template>
    </b-modal>
  </div>
</template>

<script>
// Import function call api
import { getListClass } from '@/api/manage-class';
import { getListTrainer, assignTrainer } from '@/api/trainer_assign';

// Import Component
import LazyLoad from '@/components/LazyLoad';

// Import function helper
import { handleNextPage } from '@/utils/lazyload';

// Import Toast
import { MakeToast } from '@/utils/toast_message';

export default {
  name: 'TrainerScheduled',
  components: {
    LazyLoad,
  },
  data() {
    return {
      // Searching
      keySearch: '',

      // Page
      page: 1,

      // Overlay
      overlay: {
        show: true,
        variant: 'light',
        opacity: 1,
        blur: '1rem',
        rounded: 'sm',
      },

      // show modal
      showModal: false,

      // Data
      isAssign: {
        selectedTrainer: null,
        id: '',
        index: '',
      },
      ListTrainer: [],

      // Data
      ListScheduled: [],
    };
  },
  methods: {
    // Get List Class
    handleGetListClass() {
      const length = this.ListScheduled.length;

      this.page = handleNextPage(length);

      const PARAM = {
        page: this.page,
      };

      getListClass(PARAM)
        .then((response) => {
          if (this.page > 1) {
            this.ListScheduled = [...this.ListScheduled, ...response.data];
          } else {
            this.ListScheduled = [...response.data];
          }

          this.ListScheduled = [...new Map(this.ListScheduled.map(item => [item['class_id'], item])).values()];
          this.overlay.show = false;
        });
    },

    // handleOpenModal
    handleOpenModal(scheduled, index) {
      this.isResetDataModal();
      const ID = scheduled.class_id;
      const TRAINER = scheduled.class_trainer;

      this.handleGetListTrainer();
      this.isAssign.id = ID;
      this.isAssign.indexSchecduled = index;

      if (TRAINER.length === 0) {
        this.selectedTrainer = null;
      } else {
        this.isAssign.selectedTrainer = TRAINER.trainer_id;
      }

      this.showModal = true;
    },

    // handle get list trainer
    async handleGetListTrainer() {
      await getListTrainer()
        .then((response) => {
          this.ListTrainer = response;
        });
    },

    isResetDataModal() {
      const ASSIGN = {
        selectedTrainer: null,
        id: '',
        index: '',
      };

      this.isAssign = ASSIGN;
    },

    async handleAssignTrainer() {
      const ID_CLASS = {
        'id': this.isAssign.id,
      };

      const ASSIGN = {
        'class_trainer': this.isAssign.selectedTrainer,
      };

      if (ASSIGN.class_trainer !== null) {
        await assignTrainer(ASSIGN, ID_CLASS)
          .then(() => {
            MakeToast({
              variant: 'success',
              title: this.$t('views.trainer_scheduled.message.success'),
              content: this.$t('views.trainer_scheduled.message.assign-success'),
              toaster: 'b-toaster-top-right',
            });

            this.showModal = false;
            this.page = handleNextPage(this.isAssign.length);
            this.handleGetListClass();
          });
      } else {
        MakeToast({
          variant: 'warning',
          title: this.$t('views.trainer_scheduled.valid.title'),
          content: this.$t('views.trainer_scheduled.valid.assign'),
          toaster: 'b-toaster-top-right',
        });
      }
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
        min-width: 50px;
        max-width: 50px;
        word-break: break-all;
      }

      td.zone-min-width {
        min-width: 50px;
        max-width: 50px;
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
        width: 250px;
      }

      .zone-button-control {
        text-align: center;

        button {
          background-color: #fb8c00;
          border: none;
        }
      }
    }
  }
</style>
