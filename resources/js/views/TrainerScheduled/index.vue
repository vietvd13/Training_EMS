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
                    <b-th>
                      <span>{{ $t('views.trainer_scheduled.table.no') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.trainer_scheduled.table.id') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.trainer_scheduled.table.class-name') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.trainer_scheduled.table.course-name') }}</span>
                    </b-th>

                    <b-th>
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
                      <span>{{ scheduled.id }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ scheduled.class_name }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ scheduled.course_name }}</span>
                    </b-td>

                    <b-td>
                      <div>
                        <b-button>{{ $t('views.trainer_scheduled.table.assign') }}</b-button>
                      </div>
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
export default {
  name: 'TrainerScheduled',
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

      // Data
      ListScheduled: [],
    };
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
    }
  }
</style>
