<template>
  <div style="margin-top: 20px">
    <div class="zone-header-page">
      <b-row>
        <b-col sm="4">
          <div class="zone-controls">
            <b-button @click="handleOpenModal()">{{ $t('views.manage-class.create-new') }}</b-button>
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
                        <b-button @click="handleOpenModal()">
                          {{ $t('views.manage-class.modal.edit') }}
                        </b-button>
                      </div>

                      <div class="zone-button-delete">
                        <b-button @click="handleDeleteClass()">
                          {{ $t('views.manage-class.modal.delete') }}
                        </b-button>
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
  name: 'ManageClass',
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
    };
  },
  methods: {
    // Get List Class
    handleGetListClass() {

    },

    // Handle Open Modal
    handleOpenModal() {

    },

    // Handle Create Class
    handleCreateClass() {

    },

    // Handle Update Class
    handleUpdateClass() {

    },

    // Handle Delete Class
    handleDeleteClass() {

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
