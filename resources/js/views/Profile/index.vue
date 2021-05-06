<template>
  <div>
    <div class="zone--profile">
      <b-row>

        <b-col style="margin: 0 auto;">
          <div class="card">
            <div class="card-body zone--edit-info" style="min-height: 320px;">
              <b-form-group
                label-cols="3"
                label-cols-lg="2"
                label-size="md"
                style="font-weight: 600"
                :label="$t('views.profile.fullname') + ':'"
              >
                <b-form-input v-model="InformationUser.fullname" :placeholder="$t('views.profile.enter-fullname')" />
              </b-form-group>

              <b-form-group
                label-cols="3"
                label-cols-lg="2"
                label-size="md"
                style="font-weight: 600"
                :label="$t('views.profile.email') + ':'"
              >
                <b-form-input v-model="InformationUser.email" :placeholder="$t('views.profile.enter-email')" />
              </b-form-group>

              <b-form-group
                label-cols="3"
                label-cols-lg="2"
                label-size="md"
                style="font-weight: 600"
                :label="$t('views.profile.new-password') + ':'"
              >
                <b-form-input v-model="InformationUser.newPassword" :placeholder="$t('views.profile.enter-newpassword')" type="password" />
              </b-form-group>

              <b-form-group
                label-cols="3"
                label-cols-lg="2"
                label-size="md"
                style="font-weight: 600"
                :label="$t('views.profile.cf-new-password') + ':'"
              >
                <b-form-input v-model="InformationUser.cfNewPassword" :placeholder="$t('views.profile.enter-cfnewpassword')" type="password" />
              </b-form-group>

              <div v-if="InformationUser.roles === 'trainee'">
                <b-form-group
                  label-cols="3"
                  label-cols-lg="2"
                  label-size="md"
                  style="font-weight: 600"
                  :label="$t('views.manage-user.modal.dob')"
                  label-for="input-dob"
                >
                  <b-form-input id="input-dob" v-model="InformationUser.birthday" type="date" />
                </b-form-group>

                <b-form-group
                  v-if="InformationUser.birthday !== null"
                  label-cols="3"
                  label-cols-lg="2"
                  label-size="md"
                  style="font-weight: 600"
                  :label="$t('views.manage-user.modal.age')"
                  label-for="input-age"
                >
                  <span id="input-age">{{ getAgeByDOB(InformationUser.birthday) }}</span>
                </b-form-group>

                <b-form-group
                  label-cols="3"
                  label-cols-lg="2"
                  label-size="md"
                  style="font-weight: 600"
                  :label="$t('views.manage-user.modal.education_level')"
                  label-for="input-age"
                >
                  <b-form-select
                    id="input-education_level"
                    v-model="InformationUser.education_level"
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
                  label-cols="3"
                  label-cols-lg="2"
                  label-size="md"
                  style="font-weight: 600"
                  :label="$t('views.manage-user.modal.major_programing')"
                  label-for="input-major_programing"
                >
                  <b-form-select
                    id="input-major_programing"
                    v-model="InformationUser.major_programing"
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
                  label-cols="3"
                  label-cols-lg="2"
                  label-size="md"
                  style="font-weight: 600"
                  :label="$t('views.manage-user.modal.toeic_grade')"
                  label-for="input-toeic_grade"
                >
                  <b-form-input id="input-toeic_grade" v-model="InformationUser.toeic_grade" type="number" :placeholder="$t('views.manage-user.modal.enter_toeic_grade')" />
                </b-form-group>

                <b-form-group
                  label-cols="3"
                  label-cols-lg="2"
                  label-size="md"
                  style="font-weight: 600"
                  :label="$t('views.manage-user.modal.exp_detail')"
                  label-for="input-exp_detail"
                >
                  <b-form-input id="input-exp_detail" v-model="InformationUser.exp_detail" type="text" :placeholder="$t('views.manage-user.modal.enter_exp_detail')" />
                </b-form-group>

                <b-form-group
                  label-cols="3"
                  label-cols-lg="2"
                  label-size="md"
                  style="font-weight: 600"
                  :label="$t('views.manage-user.modal.department')"
                  label-for="input-department"
                >
                  <b-form-input id="input-department" v-model="InformationUser.department" type="text" :placeholder="$t('views.manage-user.modal.enter_department')" />
                </b-form-group>

                <b-form-group
                  label-cols="3"
                  label-cols-lg="2"
                  label-size="md"
                  style="font-weight: 600"
                  :label="$t('views.manage-user.modal.position')"
                  label-for="input-position"
                >
                  <b-form-input id="input-position" v-model="InformationUser.position" type="text" :placeholder="$t('views.manage-user.modal.enter_position')" />
                </b-form-group>
              </div>

              <div v-if="InformationUser.roles === 'trainer'">
                <b-form-group
                  label-cols="3"
                  label-cols-lg="2"
                  label-size="md"
                  style="font-weight: 600"
                  :label="$t('views.manage-user.modal.in_ternal')"
                  label-for="input-in_ternal"
                >
                  <b-form-checkbox v-model="InformationUser.ex_in_ternal" name="check-button" switch />
                </b-form-group>

                <b-form-group
                  label-cols="3"
                  label-cols-lg="2"
                  label-size="md"
                  style="font-weight: 600"
                  :label="$t('views.manage-user.modal.address')"
                  label-for="input-address"
                >
                  <b-form-input id="input-address" v-model="InformationUser.address" type="text" :placeholder="$t('views.manage-user.modal.enter_address')" />
                </b-form-group>
              </div>

              <div class="zone-button-submit">
                <b-button @click="handleEditInfor()">{{ $t('views.profile.submit') }}</b-button>
              </div>
            </div>
          </div>
        </b-col>

      </b-row>
    </div>
  </div>
</template>

<script>
// Import function api
import { getProfile, putUpdateUser } from '@/api/profile';

// Import function helper
import { deCodeRole, getAgeByDOB } from '@/utils/deCode';
import { validEmail, IsEmptyOrWhiteSpace } from '@/utils/validate';

// Import Const Value
import ConstValue from '../../../../const/const_value.json';

// Import Toast
import { MakeToast } from '@/utils/toast_message';

export default {
  name: 'Profile',
  data() {
    return {
      ConstValue: ConstValue,

      InformationUser: {
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

      getAgeByDOB: getAgeByDOB,
    };
  },
  mounted() {
    this.handleGETProfile();
  },
  methods: {
    handleGETProfile() {
      const ID = {
        'id': this.$store.getters.userId,
      };

      getProfile(ID)
        .then((response) => {
          const USER = response.data;

          this.InformationUser.id = USER.id;
          this.InformationUser.email = USER.email;
          this.InformationUser.password = '';
          this.InformationUser.fullname = USER.name;
          this.InformationUser.roles = USER.roles.join('');
          this.InformationUser.role = deCodeRole(USER.roles.join(''));
          this.InformationUser.birthday = USER.birthday || null;
          this.InformationUser.education_level = USER.education_level || null;
          this.InformationUser.major_programing = USER.major_programing || null;
          this.InformationUser.toeic_grade = USER.toeic_grade || 0;
          this.InformationUser.exp_detail = USER.exp_detail || '';
          this.InformationUser.ex_in_ternal = Boolean(USER.ex_in_ternal);
          this.InformationUser.address = USER.address || '';
          this.InformationUser.department = USER.department || '';
          this.InformationUser.position = USER.position || '';
        });
    },
    handleEditInfor() {
      const ID = this.InformationUser.id;
      const FULLNAME = this.InformationUser.fullname;
      const EMAIL = this.InformationUser.email;
      const PASSWORD = this.InformationUser.password;
      const ROLE = this.InformationUser.role;

      var USER = {
        'user_full_name': FULLNAME,
        'user_account': EMAIL,
        'user_password': PASSWORD,
        'user_role': ROLE,
      };

      if (this.InformationUser.role === 3) {
        USER.user_ex_in_ternal = +!!this.InformationUser.ex_in_ternal;
        USER.user_address = this.InformationUser.address;
        USER.user_birthday = '';
        USER.user_education_level = null;
        USER.user_major_programing = '';
        USER.user_toeic_grade = null;
        USER.user_exp_detail = '';
        USER.user_department = '';
        USER.user_position = '';
      } else if (this.InformationUser.role === 4) {
        USER.user_birthday = this.InformationUser.birthday;
        USER.user_education_level = this.InformationUser.education_level;
        USER.user_major_programing = this.InformationUser.major_programing;
        USER.user_toeic_grade = this.InformationUser.toeic_grade;
        USER.user_exp_detail = this.InformationUser.exp_detail;
        USER.user_department = this.InformationUser.department;
        USER.user_position = this.InformationUser.position;
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

            this.handleGETProfile();
          });
      } else {
        const TITLE = 'views.manage-user.valid.title';

        MakeToast({
          variant: 'warning',
          title: this.$t(TITLE),
          content: this.$t(validUser.type),
          toaster: 'b-toaster-top-right',
        });

        this.handleGETProfile();
      }
    },

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
  },
};
</script>

<style lang="scss" scoped>
  .zone--profile {
    margin-top: 10px;
    margin-bottom: 10px;
  }

  .zone--avatar {
    display: inline;
    justify-content: center;
    align-items: center;
    text-align: center;

    .zone--edit-avatar {
      margin-top: 30px;

      button {
        background-color: #fb8c00;
        border: none;

        &:focus {
          background-color: #fb8c00;
        }

        &:hover {
          opacity: 0.8;
        }
      }
    }
  }

  .zone--edit-info {
    .zone-button-submit {
      text-align: center;
        button {
          background-color: #fb8c00;
          border: none;
          margin-top: 20px;
          min-width: 150px;

          &:focus {
            background-color: #fb8c00;
          }

          &:hover {
            opacity: 0.8;
          }
        }
    }
  }
</style>
