<template>
  <div>
    <b-row>
      <b-col sm="4" card>
        <div class="mb-2 ">
          <center class="container-avatar ">
            <b-avatar class="avatar" :src="user.avatar" size="10rem" />
            <b-button v-b-modal.PopUpChangeAvatar variant="dark" class="btn-avatar"><b-icon icon="gear" class="gearicon" /></b-button>
          </center>
        </div>
      </b-col>
      <b-col sm="7" class="imformation-user card">
        <b-tabs content-class="mt-3">
          <b-tab :title="$t('profile.information')" class="tab" active>
            <b-form>
              <b-form-group
                id="input-group-email"
                :label="$t('profile.form.label_mail')"
                label-for="input-email"
              >
                <b-form-input
                  id="input-email"
                  v-model="form.email"
                  type="email"
                  required
                  :placeholder="$t('profile.form.placeholder_mail')"
                  aria-describedby="input-live-help input-live-feedback"
                  :state="stateEmail"
                >{{ form.email }} </b-form-input>
                <b-form-invalid-feedback id="input-live-feedback">
                  {{ $t('profile.validation.email') }}
                </b-form-invalid-feedback>
              </b-form-group>

              <b-form-group id="input-group-name" :label="$t('profile.form.label_name')" label-for="input-name">
                <b-form-input
                  id="input-name"
                  v-model="form.name"
                  required
                  :placeholder="$t('profile.form.placeholder_name')"
                  aria-describedby="input-live-help input-live-feedback"
                  :state="stateName"
                >   {{ form.name }}</b-form-input>
                <b-form-invalid-feedback id="input-live-feedback">
                  {{ $t('profile.validation.name_at_least_2_letters') }}
                </b-form-invalid-feedback>
              </b-form-group>
              <b-button class="btn-submit" trim @click="onSubmitProfile">{{ $t('profile.submit') }}</b-button>
            </b-form>
          </b-tab>
          <b-tab :title="$t('profile.change_password')" class="tab">
            <b-button @click="onClickOpenForm()"><b-icon icon="gear" aria-hidden="true" />{{ $t(editPassword) }}</b-button>
            <b-collapse id="password-collapse">
              <b-form @reset="onReset">
                <b-form-group
                  id="input-group-password"
                  :label="$t('profile.form.currentPassword')"
                  label-for="current-password"
                >
                  <b-form-input
                    id="current-password"
                    v-model="formChangePass.currentPassword"
                    type="password"
                    required
                    :placeholder="$t('profile.form.placeholder_currentPassword')"
                    aria-describedby="input-live-help input-live-feedback"
                    :state="passwordState"
                  />
                  <b-form-invalid-feedback id="input-live-feedback">
                    {{ $t(mess_error_current_password) }}
                  </b-form-invalid-feedback>
                </b-form-group>

                <b-form-group id="input-group-password" :label="$t('profile.form.newPassword')" label-for="new-passwod">
                  <b-form-input
                    id="new-passwod"
                    v-model="formChangePass.newPassword"
                    type="password"
                    required
                    aria-describedby="input-live-help input-live-feedback"
                    :placeholder="$t('profile.form.placeholder_newPassword')"
                    :state="newPasswordState"
                  />
                  <b-form-invalid-feedback id="input-live-feedback">
                    {{ $t(mess_error_password) }}
                  </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group id="input-group-password" :label="$t('profile.form.confirmPassword')" label-for="confrim-new-password">
                  <b-form-input
                    id="confrim-new-password"
                    v-model="formChangePass.confirmNewPassword"
                    type="password"
                    required
                    :placeholder="$t('profile.form.placeholder_confirmPassword')"
                    aria-describedby="input-live-help input-live-feedback"
                    :state="confirmNewPasswordState"
                  />
                  <b-form-invalid-feedback id="input-live-feedback">
                    {{ $t(mess_error_cofirm_password) }}
                  </b-form-invalid-feedback>
                </b-form-group>
                <b-button class="btn-submit" @click="onSubmitPassword">{{ $t('profile.submit') }}</b-button>
              </b-form>
            </b-collapse>
          </b-tab>
        </b-tabs>
      </b-col>
    </b-row>

    <b-modal
      id="PopUpChangeAvatar"
      :title="$t('profile.uploadAvatar.title')"
      :ok-title="$t('profile.uploadAvatar.btn_ok')"
      :cancel-title="$t('profile.uploadAvatar.btn_cancel')"
      @ok="onUpdateAvatar"
    >
      <center>
        <b-button variant="primary" class="btn-inputAvatar"> {{ $t('profile.uploadAvatar.btn_Upload') }} </b-button>
        <b-form-file id="pic_avatar" accept="image/jpeg, image/png, image/gif" class="inputAvatar" @change="preview_avatar" />
        <div id="preview_avatar">
          <b-img :src="avatarPreview" fluid alt="Fluid image" class="AvatarPreview" />
        </div>
      </center>
    </b-modal>

  </div>

</template>

<script>
import { getProfile, updateProfile, UpdateAvatar, updatePassword } from '@/api/profile_API.js';
import { MakeToast } from '@/utils/toast_message';
import { validEmail } from '@/utils/validate';
export default {
  data() {
    return {
      errors: [],
      isOpenForm: true,
      editPassword: 'profile.edit_password',
      user_id: 1,
      form: {
        email: '',
        name: '',
      },
      formChangePass: {
        currentPassword: '',
        newPassword: '',
        confirmNewPassword: '',
      },
      showEditPassword: false,
      avatarPreview: '',
      user:
            {
              id: 1,
              email: '',
              roles: '',
              avatar: '',
              name: '',
            },
      mess_error: ['Edit Fail'],
      mess_error_password: '',
      mess_error_current_password: '',
      mess_error_cofirm_password: '',
    };
  },
  computed: {
    stateEmail() {
      var emails = this.form.email;
      return validEmail(emails);
    },
    stateName() {
      return this.form.name.length > 1;
    },
    passwordState() {
      return this.formChangePass.currentPassword.length > 6;
    },
    newPasswordState() {
      return this.formChangePass.newPassword.length > 6;
    },
    confirmNewPasswordState() {
      return this.formChangePass.newPassword === this.formChangePass.confirmNewPassword;
    },
  },
  watch: {
    passwordState() {
      if (this.formChangePass.newPassword.length < 6){
        this.mess_error_current_password = 'profile.validation.password_more_than_5_characters';
      }

      return this.formChangePass.currentPassword.length > 6;
    },
    newPasswordState() {
      if (this.formChangePass.newPassword.length < 6){
        this.mess_error_password = 'profile.validation.password_more_than_5_characters';
      }

      return this.formChangePass.newPassword.length > 6;
    },
    confirmNewPasswordState() {
      if (this.formChangePass.newPassword === this.formChangePass.confirmNewPassword){
        this.mess_error_cofirm_password = 'profile.validation.password_mismatch';
      }

      return this.formChangePass.newPassword === this.formChangePass.confirmNewPassword;
    },
  },
  created() {
    this.fillformData(this.$store.getters.email, this.$store.getters.name, this.$store.getters.avatar);
  },
  methods: {
    onClickOpenForm(){
      this.isOpenForm = !this.isOpenForm;
      this.$root.$emit('bv::toggle::collapse', 'password-collapse');
      this.editPassword = this.isOpenForm ? 'profile.edit_password' : 'profile.close_edit_password';
    },
    onSubmitProfile(){
      if (this.stateEmail){
        const resEdit = updateProfile(this.user_id, {
          id: this.user_id,
          email: this.form.email,
          name: this.form.name,
        });
        resEdit.then((data) => {
          if (data.statusCode === 200 && this.form.name.length > 1 && this.stateEmail === true) {
            MakeToast({
              variant: 'success',
              title: this.$t('profile.toast.editInformation.title'),
              content: this.$t('profile.toast.editInformation.content_successful'),
              toaster: 'b-toaster-bottom-center',
            });
          } else {
            MakeToast({
              variant: 'danger',
              title: this.$t('profile.toast.editInformation.title'),
              content: this.$t('profile.toast.editInformation.content_unsuccessful'),
              toaster: 'b-toaster-bottom-center',
            });
          }
        });
      }
    },
    fillformData(email, name, avatar){
      this.form.email = email;
      this.form.name = name;
      this.user.avatar = process.env.MIX_STORE_IMAGE_URL + '/avatars/' + avatar;
      this.avatarPreview = this.user.avatar;
    },
    async getDataProfile(){
      var dataTaken = await getProfile(this.user_id);
      this.fillformData(dataTaken.data.email, dataTaken.data.name, dataTaken.data.avatar);
    },
    onReset(){ // reset form password
      this.formChangePass.currentPassword = '';
      this.formChangePass.newPassword = '';
      this.formChangePass.confirmNewPassword = '';
    },
    async onSubmitPassword(){ // update password
      const resEditp = updatePassword({
        userId: this.user_id,
        password: this.formChangePass.currentPassword,
        newPassword: this.formChangePass.newPassword,
        confirmNewPassword: this.formChangePass.confirmNewPassword,
      });
      resEditp.then((data) => {
        if (data.error){
          this.mess_error = data.error;
        }
        if (data.statusCode === 200) {
          this.onClickOpenForm();
          MakeToast({
            variant: 'success',
            title: this.$t('profile.toast.editPassword.title'),
            content: this.$t('profile.toast.editPassword.content_successful'),
            toaster: 'b-toaster-bottom-center',
          });
          this.onReset();
        } else {
          MakeToast({
            variant: 'danger',
            title: this.$t('profile.toast.editPassword.title'),
            content: this.$t('profile.toast.editPassword.content_unsuccessful'),
            toaster: 'b-toaster-bottom-center',
          });
        }
      });
    },
    preview_avatar(e) { // preview avatar after change avatar
      const file_correct = event.target.files[0];
      this.avatarPreview = URL.createObjectURL(file_correct);
    },
    async onUpdateAvatar(){
      if (document.getElementById('pic_avatar').files[0] !== undefined){
        var newAvatar = new FormData();
        newAvatar.append('avatar', document.getElementById('pic_avatar').files[0]);
        newAvatar.append('id', this.user.id);
        await UpdateAvatar(this.user.id, newAvatar)
          .then((res) => {
            this.getDataProfile();
          });
        MakeToast({
          variant: 'success',
          title: this.$t('profile.toast.editAvatar.title'),
          content: this.$t('profile.toast.editAvatar.content_successful'),
          toaster: 'b-toaster-bottom-center',
        });
      } else {
        MakeToast({
          variant: 'danger',
          title: this.$t('profile.toast.editAvatar.title'),
          content: this.$t('profile.toast.editAvatar.content_unsuccessful'),
          toaster: 'b-toaster-bottom-center',
        });
      }
    },
  },

};
</script>

<style>
.row{
    width: 100%;
}
.container{
    margin:5px ;
}
.btn-submit{
    background-color: #7386D5;
    border: none;
}
.tab{
    color:#7386D5 ;
}
.imformation-user{
    margin-left: 5px ;
    margin-top:  10px ;
}
.container-avatar{
    margin-top:10px ;
    position: relative;
    width: 100%;
    max-width: 400px;
}
.gearicon{
    text-align: center;
}
.container-avatar .b-avatar{
    width: 100%;
    height: auto;
}
.container-avatar .btn-avatar{
    position:absolute;
    top:95%;
    left: 50%;
    transform: translate(-45%, -50%);
    -ms-transform: translate(-45%, -50%);
    padding: 10px auto;
    border: none;
    cursor: pointer;
    text-align: center;
    opacity: 90%;
    border-radius: 50%;

}
.container-avatar .btn-avatar:hover{
    overflow: hidden;
}
.avatar {
 border: gray solid 3px;
}
.btn-inputAvatar{
     border: none;
     padding: 8px 20px;
     font-weight: 500;
     border-radius: 4px;
     font-size: 14px;
     width: 65%;
}
.inputAvatar{
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
  width: 100%;

}
.AvatarPreview{
    margin-top: 5px;
}
</style>
