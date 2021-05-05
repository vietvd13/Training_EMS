<template>
  <div style="margin-top: 20px;">
    <div class="zone-header-page">
      <b-row>
        <b-col sm="4">
          <div class="zone-controls">
            <b-button @click="handleOpenModal(null, null)">{{ $t('views.manage-user.create-new') }}</b-button>
          </div>
        </b-col>
        <b-col sm="5" />
        <b-col sm="3">
          <div class="zone-controls">
            <b-form-input v-model="keySearch" :placeholder="$t('views.manage-user.enter-search')" />
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
                      <span>{{ $t('views.manage-user.table.no') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.manage-user.table.id') }}</span>
                    </b-th>

                    <b-th class="zone-min-width">
                      <span>{{ $t('views.manage-user.table.fullname') }}</span>
                    </b-th>

                    <b-th class="zone-min-width">
                      <span>{{ $t('views.manage-user.table.email') }}</span>
                    </b-th>

                    <b-th class="zone-min-width">
                      <span>{{ $t('views.manage-user.table.role') }}</span>
                    </b-th>

                    <b-th>
                      <span>{{ $t('views.manage-user.table.actions') }}</span>
                    </b-th>
                  </b-tr>
                </b-thead>

                <b-tbody>
                  <b-tr
                    v-for="(user, indexUser) in ListUser"
                    :key="indexUser"
                  >
                    <b-td>
                      <span>{{ indexUser + 1 }}</span>
                    </b-td>

                    <b-td>
                      <span>{{ user.id }}</span>
                    </b-td>

                    <b-td class="zone-min-width">
                      <span>{{ user.name }}</span>
                    </b-td>

                    <b-td class="zone-min-width">
                      <span>{{ user.email }}</span>
                    </b-td>

                    <b-td class="zone-min-width">
                      <span>{{ $t(getNameRole(deCodeRole(user.roles[0]))) }}</span>
                    </b-td>

                    <b-td class="zone-button-control">
                      <div class="zone-button-edit">
                        <b-button @click="handleOpenModal(user, indexUser)">
                          {{ $t('views.manage-user.modal.edit') }}
                        </b-button>
                      </div>

                      <div class="zone-button-delete">
                        <b-button @click="handleDeleteUser(user.id)">
                          {{ $t('views.manage-user.modal.delete') }}
                        </b-button>
                      </div>
                    </b-td>
                  </b-tr>

                  <LazyLoad @lazyload="handleGetListUser()" />
                </b-tbody>
              </b-table-simple>
            </div>
          </b-overlay>
        </div>
      </div>
    </div>

    <b-modal
      id="modal-user"
      v-model="showModal"
      size="lg"
      centered
      :title="isAction === 'CREATE' ? $t('views.manage-user.modal.title-create') : $t('views.manage-user.modal.title-edit')"
    >
      <b-form-group
        label-cols="4"
        label-cols-lg="2"
        :label="$t('views.manage-user.modal.fullname')"
        label-for="input-fullname"
      >
        <b-form-input
          id="input-fullname"
          v-model="User.fullname"
          :placeholder="$t('views.manage-user.modal.enter-fullname')"
        />
      </b-form-group>

      <b-form-group
        label-cols="4"
        label-cols-lg="2"
        :label="$t('views.manage-user.modal.email')"
        label-for="input-email"
      >
        <b-form-input
          id="input-email"
          v-model="User.email"
          :placeholder="$t('views.manage-user.modal.enter-email')"
          :disabled="isAction === 'CREATE' ? false : true"
        />
      </b-form-group>

      <b-form-group
        label-cols="4"
        label-cols-lg="2"
        :label="$t('views.manage-user.modal.password')"
        label-for="input-password"
      >
        <b-form-input
          id="input-password"
          v-model="User.password"
          type="password"
          :placeholder="$t('views.manage-user.modal.enter-password')"
        />
      </b-form-group>

      <b-form-group
        label-cols="4"
        label-cols-lg="2"
        :label="$t('views.manage-user.modal.role')"
        label-for="input-role"
      >
        <b-form-select
          id="input-role"
          v-model="User.role"
        >
          <b-form-select-option
            :value="null"
            disabled
          >
            {{ $t('select.please_select') }}
          </b-form-select-option>

          <b-form-select-option
            v-for="(role, indexRole) in ConstValue.SELECT_ROLE"
            :key="indexRole"
            :value="role.value"
            :disabled="isDisableRole(indexRole)"
          >
            {{ $t(role.label) }}
          </b-form-select-option>

        </b-form-select>
      </b-form-group>

      <div v-if="User.roles === 'trainee'">
        <b-form-group
          label-cols="4"
          label-cols-lg="2"
          :label="$t('views.manage-user.modal.dob')"
          label-for="input-dob"
        >
          <b-form-input id="input-dob" v-model="User.birthday" type="date" />
        </b-form-group>

        <b-form-group
          label-cols="4"
          label-cols-lg="2"
          :label="$t('views.manage-user.modal.age')"
          label-for="input-age"
        >
          <span id="input-age">{{ User.birthday }}</span>
        </b-form-group>

        <b-form-group
          label-cols="4"
          label-cols-lg="2"
          :label="$t('views.manage-user.modal.education_level')"
          label-for="input-age"
        >
          <b-form-select
            id="input-education_level"
            v-model="User.education_level"
          >
            <b-form-select-option
              :value="null"
              disabled
            >
              {{ $t('select.please_select') }}
            </b-form-select-option>

            <b-form-select-option
              :value="1"
            >
              {{ $t('views.manage-user.modal.cd') }}
            </b-form-select-option>

            <b-form-select-option
              :value="2"
            >
              {{ $t('views.manage-user.modal.dh') }}
            </b-form-select-option>

          </b-form-select>
        </b-form-group>

        <b-form-group
          label-cols="4"
          label-cols-lg="2"
          :label="$t('views.manage-user.modal.major_programing')"
          label-for="input-major_programing"
        >
          <b-form-select
            id="input-major_programing"
            v-model="User.major_programing"
          >
            <b-form-select-option
              :value="null"
              disabled
            >
              {{ $t('select.please_select') }}
            </b-form-select-option>

            <b-form-select-option
              :value="1"
            >
              {{ $t('views.manage-user.modal.php') }}
            </b-form-select-option>

            <b-form-select-option
              :value="2"
            >
              {{ $t('views.manage-user.modal.javascript') }}
            </b-form-select-option>

            <b-form-select-option
              :value="3"
            >
              {{ $t('views.manage-user.modal.c') }}
            </b-form-select-option>

            <b-form-select-option
              :value="4"
            >
              {{ $t('views.manage-user.modal.c-plus') }}
            </b-form-select-option>

            <b-form-select-option
              :value="5"
            >
              {{ $t('views.manage-user.modal.python') }}
            </b-form-select-option>

          </b-form-select>
        </b-form-group>

        <b-form-group
          label-cols="4"
          label-cols-lg="2"
          :label="$t('views.manage-user.modal.toeic_grade')"
          label-for="input-toeic_grade"
        >
          <b-form-input id="input-toeic_grade" v-model="User.toeic_grade" type="number" />
        </b-form-group>

        <b-form-group
          label-cols="4"
          label-cols-lg="2"
          :label="$t('views.manage-user.modal.exp_detail')"
          label-for="input-exp_detail"
        >
          <b-form-input id="input-exp_detail" v-model="User.exp_detail" type="text" />
        </b-form-group>

        <b-form-group
          label-cols="4"
          label-cols-lg="2"
          :label="$t('views.manage-user.modal.department')"
          label-for="input-department"
        >
          <b-form-input id="input-department" v-model="User.department" type="text" />
        </b-form-group>

        <b-form-group
          label-cols="4"
          label-cols-lg="2"
          :label="$t('views.manage-user.modal.position')"
          label-for="input-position"
        >
          <b-form-input id="input-position" v-model="User.position" type="text" />
        </b-form-group>
      </div>

      <div v-if="User.roles === 'trainer'">
        <b-form-group
          label-cols="4"
          label-cols-lg="2"
          :label="$t('views.manage-user.modal.in_ternal')"
          label-for="input-in_ternal"
        >
          <b-form-checkbox v-model="User.ex_in_ternal" name="check-button" switch />
        </b-form-group>

        <b-form-group
          label-cols="4"
          label-cols-lg="2"
          :label="$t('views.manage-user.modal.address')"
          label-for="input-address"
        >
          <b-form-input id="input-address" v-model="User.address" type="text" />
        </b-form-group>
      </div>

      <template #modal-footer>
        <div>
          <b-button
            v-if="isAction === 'CREATE'"
            @click="handleCreateUser()"
          >
            {{ $t('views.manage-user.modal.create') }}
          </b-button>

          <b-button
            v-if="isAction === 'EDIT'"
            @click="handleUpdateUser()"
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
// Import Function call api
import { getListUser, getListUserTrainerTrainee, postCreateUser, putUpdateUser, deleteUser } from '@/api/manager-user';

// Import Component
import LazyLoad from '@/components/LazyLoad';

// Import Const Value
import ConstValue from '../../../../const/const_value.json';

// Import function helper
import { deCodeRole, getNameRole } from '@/utils/deCode';
import { handleNextPage } from '@/utils/lazyload';
import { validEmail, IsEmptyOrWhiteSpace } from '@/utils/validate';

// Import Toast
import { MakeToast } from '@/utils/toast_message';

export default {
  name: 'ManageUser',
  components: {
    LazyLoad,
  },
  data() {
    return {
      // Const
      ConstValue: ConstValue,

      // Function Helper
      deCodeRole: deCodeRole,
      getNameRole: getNameRole,

      // Search & Fliter
      keySearch: '',

      // List store data
      ListUser: [],

      // Overlay
      overlay: {
        show: true,
        variant: 'light',
        opacity: 1,
        blur: '1rem',
        rounded: 'sm',
      },

      // Modal
      showModal: false,

      // User
      User: {
        id: '',
        fullname: '',
        email: '',
        password: '',
        roles: null,
        role: null,
        avatar: null,
        birthday: null,
        education_level: null,
        major_programing: null,
        toeic_grade: null,
        exp_detail: null,
        ex_in_ternal: false,
        address: null,
        department: null,
        position: null,
      },

      // Actions
      isAction: '',

      // Page
      page: 1,

      // Index
      isIndexEdit: '',

      isUserRole: this.$store.getters.roles.join(''),

    };
  },
  computed: {
    isRoleChange() {
      return this.User.role;
    },
    isHandleSearch() {
      return this.keySearch;
    },
  },
  watch: {
    isRoleChange() {
      if (this.User.role === 3) {
        this.User.roles = 'trainer';
      } else if (this.User.role === 4) {
        this.User.roles = 'trainee';
      } else {
        this.User.roles = null;
      }
    },
    isHandleSearch() {
      this.ListUser.length = 0;
      this.handleGetListUser();
    },
  },
  methods: {
    // Get List User
    handleGetListUser() {
      let length;

      if (this.isAction === 'CREATE' || this.isAction === '' || this.isAction === 'DELETE') {
        length = this.ListUser.length;
      } else if (this.isAction === 'EDIT') {
        length = this.isIndexEdit;
      }

      this.page = handleNextPage(length);

      var param = {
        page: this.page,
      };

      if (!IsEmptyOrWhiteSpace(this.keySearch)) {
        param.name = this.keySearch;
      }

      if (this.isUserRole === ConstValue.ROLE.ADMIN) {
        getListUser(param)
          .then((response) => {
            if (this.page > 1) {
              this.ListUser = [...this.ListUser, ...response.data];
            } else {
              this.ListUser = [...response.data];
            }

            this.ListUser = [...new Map(this.ListUser.map(item => [item['id'], item])).values()];
            this.overlay.show = false;
          });
      } else {
        getListUserTrainerTrainee(param)
          .then((response) => {
            if (this.page > 1) {
              this.ListUser = [...this.ListUser, ...response.data];
            } else {
              this.ListUser = [...response.data];
            }

            this.ListUser = [...new Map(this.ListUser.map(item => [item['id'], item])).values()];
            this.overlay.show = false;
          });
      }
    },

    // Open Modal
    handleOpenModal(user, index) {
      this.showModal = true;
      this.isResetDataModal();

      if (user !== null) {
        this.User.id = user.id;
        this.User.email = user.email;
        this.User.password = '';
        this.User.fullname = user.name;
        this.User.roles = user.roles[0];
        this.User.role = deCodeRole(user.roles[0]);
        this.User.avatar = null;
        this.User.birthday = user.birthday || null;
        this.User.education_level = user.education_level || null;
        this.User.major_programing = user.major_programing || null;
        this.User.toeic_grade = user.toeic_grade || 0;
        this.User.exp_detail = user.exp_detail || '';
        this.User.ex_in_ternal = Boolean(user.ex_in_ternal);
        this.User.address = user.address || '';
        this.User.department = user.department || '';
        this.User.position = user.position || '';

        this.isIndexEdit = index;

        this.isAction = 'EDIT';
      } else {
        this.isAction = 'CREATE';
      }
    },

    // Create User
    handleCreateUser() {
      const FULLNAME = this.User.fullname;
      const EMAIL = this.User.email;
      const PASSWORD = this.User.password;
      const ROLE = this.User.role;

      var USER = {
        'user_full_name': FULLNAME,
        'user_account': EMAIL,
        'user_password': PASSWORD,
        'user_role': ROLE,
      };

      if (this.User.role === 3) {
        USER.user_ex_in_ternal = +!!this.User.ex_in_ternal;
        USER.user_address = this.User.address;
        USER.user_birthday = '';
        USER.user_education_level = null;
        USER.user_user_major_programing = '';
        USER.user_toeic_grade = null;
        USER.user_exp_detail = '';
        USER.user_department = '';
        USER.user_position = '';
      } else if (this.User.role === 4) {
        USER.user_birthday = this.User.birthday;
        USER.user_education_level = this.User.education_level;
        USER.user_major_programing = this.User.major_programing;
        USER.user_toeic_grade = this.User.toeic_grade;
        USER.user_exp_detail = this.User.exp_detail;
        USER.user_department = this.User.department;
        USER.user_position = this.User.position;
        USER.user_ex_in_ternal = 0;
        USER.user_address = '';
      } else {
        USER.user_ex_in_ternal = 0;
        USER.user_address = '';
        USER.user_birthday = '';
        USER.user_education_level = null;
        USER.user_major_programing = '';
        USER.user_toeic_grade = null;
        USER.user_exp_detail = '';
        USER.user_department = '';
        USER.user_position = '';
      }

      const validUser = this.isValidateUser(USER);

      if (validUser.status === true) {
        postCreateUser(USER)
          .then(() => {
            MakeToast({
              variant: 'success',
              title: this.$t('views.manage-user.message.success'),
              content: this.$t('views.manage-user.message.message-create-success'),
              toaster: 'b-toaster-top-right',
            });

            this.isResetDataModal();
            this.showModal = false;
            this.overlay.show = true;
            this.handleGetListUser();
            this.overlay.show = false;
          });
      } else {
        const TITLE = 'views.manage-user.valid.title';

        MakeToast({
          variant: 'warning',
          title: this.$t(TITLE),
          content: this.$t(validUser.type),
          toaster: 'b-toaster-top-right',

        });
      }
    },

    // Update User
    handleUpdateUser() {
      const ID = this.User.id;
      const FULLNAME = this.User.fullname;
      const EMAIL = this.User.email;
      const PASSWORD = this.User.password;
      const ROLE = this.User.role;

      var USER = {
        'user_full_name': FULLNAME,
        'user_account': EMAIL,
        'user_password': PASSWORD,
        'user_role': ROLE,
      };

      if (this.User.role === 3) {
        USER.user_ex_in_ternal = +!!this.User.ex_in_ternal;
        USER.user_address = this.User.address;
        USER.user_birthday = '';
        USER.user_education_level = null;
        USER.user_major_programing = '';
        USER.user_toeic_grade = null;
        USER.user_exp_detail = '';
        USER.user_department = '';
        USER.user_position = '';
      } else if (this.User.role === 4) {
        USER.user_birthday = this.User.birthday;
        USER.user_education_level = this.User.education_level;
        USER.user_user_major_programing = this.User.major_programing;
        USER.user_toeic_grade = this.User.toeic_grade;
        USER.user_exp_detail = this.User.exp_detail;
        USER.user_department = this.User.department;
        USER.user_position = this.User.position;
        USER.user_ex_in_ternal = 0;
        USER.user_address = '';
      } else {
        USER.user_ex_in_ternal = 0;
        USER.user_user_address = '';
        USER.user_birthday = '';
        USER.user_education_level = null;
        USER.user_major_programing = '';
        USER.user_toeic_grade = null;
        USER.user_exp_detail = '';
        USER.user_department = '';
        USER.user_position = '';
      }

      const ID_USER = {
        'id': ID,
      };

      const validUser = this.isValidateUser(USER);

      if (validUser.status === true || (validUser.status === false && validUser.type === 'views.manage-user.valid.password')) {
        putUpdateUser(USER, ID_USER)
          .then(() => {
            MakeToast({
              variant: 'success',
              title: this.$t('views.manage-user.message.success'),
              content: this.$t('views.manage-user.message.message-edit-success'),
              toaster: 'b-toaster-top-right',
            });

            this.showModal = false;
            this.overlay.show = true;
            this.handleGetListUser();
            this.overlay.show = false;
          });
      } else {
        const TITLE = 'views.manage-user.valid.title';

        MakeToast({
          variant: 'warning',
          title: this.$t(TITLE),
          content: this.$t(validUser.type),
          toaster: 'b-toaster-top-right',
        });
      }
    },

    // Delete User
    handleDeleteUser(id) {
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
            deleteUser(PARAM)
              .then(() => {
                MakeToast({
                  variant: 'success',
                  title: this.$t('views.manage-user.message.success'),
                  content: this.$t('views.manage-user.message.message-delete-success'),
                  toaster: 'b-toaster-top-right',
                });

                this.showModal = false;
                this.ListUser.length = this.ListUser.length - 1;
                this.overlay.show = true;
                this.handleGetListUser();
                this.overlay.show = false;
              });
          }
        })
        .catch(err => {
          console.log(err);
        });
    },

    // Reset Data Modal
    isResetDataModal() {
      const USER = {
        id: '',
        fullname: '',
        email: '',
        password: '',
        roles: null,
        role: null,
        avatar: null,
        birthday: null,
        major_programing: null,
        education_level: null,
        toeic_grade: null,
        exp_detail: null,
        ex_in_ternal: false,
        address: null,
        department: null,
        position: null,
      };

      this.User = USER;
    },

    // Validate form
    isValidateUser(user) {
      let isValid = {
        status: false,
        type: '',
      };

      const isCheckFullName = IsEmptyOrWhiteSpace(user.user_full_name);
      const isCheckEmail = validEmail(user.user_account);
      const isCheckPassword = IsEmptyOrWhiteSpace(user.user_password);
      const listRole = ConstValue.ROLE_ARRAY;
      const isCheckRole = listRole.includes(user.user_role);

      if (isCheckFullName === true) {
        isValid = {
          status: false,
          type: 'views.manage-user.valid.fullname',
        };

        return isValid;
      } else if (isCheckEmail === false) {
        isValid = {
          status: false,
          type: 'views.manage-user.valid.email',
        };

        return isValid;
      } else if (isCheckPassword === true) {
        isValid = {
          status: false,
          type: 'views.manage-user.valid.password',
        };

        return isValid;
      } else if (isCheckRole === false) {
        isValid = {
          status: false,
          type: 'views.manage-user.valid.role',
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

    isDisableRole(index) {
      if (this.isUserRole !== 'admin') {
        return [0, 1].includes(index);
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
