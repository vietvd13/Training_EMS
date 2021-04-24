<template>
  <div>
    <div class="zone--profile">
      <b-row>

        <b-col cols="6" sm="6" md="6" lg="2" style="margin: 0 auto;">
          <div class="card">
            <div class="card-body" style="min-height: 320px;">
              <div class="zone--avatar">
                <b-img thumbnail rounded="circle" fluid src="https://bit.ly/3gAHdKM" alt="Avatar User" />

                <div class="zone--edit-avatar">
                  <b-button @click="handleEditAva()">{{ $t('views.profile.edit-avatar') }}</b-button>
                  <input ref="editAvatar" type="file" name="editAvatar" style="display: none;">
                </div>
              </div>
            </div>
          </div>
        </b-col>

        <b-col cols="10" style="margin: 0 auto;">
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
                <b-form-input v-model="InformationUser.newPassword" :placeholder="$t('views.profile.enter-newpassword')" />
              </b-form-group>

              <b-form-group
                label-cols="3"
                label-cols-lg="2"
                label-size="md"
                style="font-weight: 600"
                :label="$t('views.profile.cf-new-password') + ':'"
              >
                <b-form-input v-model="InformationUser.cfNewPassword" :placeholder="$t('views.profile.enter-cfnewpassword')" />
              </b-form-group>

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
export default {
  name: 'Profile',
  data() {
    return {
      InformationUser: {
        id: '',
        avatar: '',
        fullname: '',
        email: '',
        newPassword: '',
        cfNewPassword: '',
      },
    };
  },
  mounted() {
    this.handleGETProfile();
  },
  methods: {
    handleGETProfile() {
      const user = this.$store.getters;

      this.InformationUser.id = user.userId;
      this.InformationUser.avatar = user.avatar;
      this.InformationUser.email = user.email;
      this.InformationUser.fullname = user.name;
      this.InformationUser.newPassword = '';
      this.InformationUser.cfNewPassword = '';
    },
    handleEditAva() {
      this.$refs.editAvatar.click();

      alert("Dev: I'm doing this function, slowly");
    },
    handleEditInfor() {
      alert("Dev: I'm doing this function, slowly");
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
