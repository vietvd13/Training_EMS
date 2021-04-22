<template>
  <div :style="{ backgroundImage: `url(${Backgroud})` }" class="background">
    <div class="container-fluid login">
      <div class="container">
        <div class="col-xl-6 col-lg-6 mx-auto login-container">
          <div class="row">

            <div class="col-lg-12 col-md-12 no-padding">
              <div class="login-box">
                <h5>{{ $t('views.login.welcome') }}</h5>
                <div class="login-row row no-margin">
                  <label for=""><i class="fas fa-envelope" /> {{ $t('views.login.email') }}</label>
                  <input v-model="loginForm.email" type="email" class="form-control form-control-sm" spellcheck="false">
                </div>

                <div class="login-row row no-margin">
                  <label for=""><i class="fas fa-unlock-alt" /> {{ $t('views.login.password') }}</label>
                  <input v-model="loginForm.password" :type="typePassword" class="form-control form-control-sm">
                </div>

                <div class="login-row row forrr no-margin">
                  <p> <input type="checkbox" @click="showPassword"> {{ $t('views.login.showpassword') }}</p>
                </div>

                <div class="login-row btnroo row no-margin">
                  <button type="button" class="btn btn-primary btn-sm" @click="doLogin"> {{ $t('views.login.login') }}</button>
                </div>

                <div class="select-lang">
                  <!-- Start Dropdown -->
                  <b-dropdown right text="Right align">
                    <!-- Icon change -->
                    <template #button-content>
                      <span>{{ $t('views.login.changelang') }}</span>
                    </template>
                    <!-- Options -->
                    <b-dropdown-item :disabled="language==='en'" @click="handleSetLanguage('en')">
                      {{ $t('navbar.languages.en') }}
                    </b-dropdown-item>
                    <b-dropdown-item :disabled="language==='ja'" @click="handleSetLanguage('ja')">
                      {{ $t('navbar.languages.ja') }}
                    </b-dropdown-item>
                  </b-dropdown>
                  <!-- End Dropdown -->
                </div>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { getCSRF } from '@/api/login';
import { validEmail } from '@/utils/validate';
import { MakeToast } from '@/utils/toast_message';
import Backgroud from '@/assets/images/background-login.jpg';

export default {
  name: 'Login',
  data() {
    return {
      loginForm: {
        email: 'admin@laravue.dev',
        password: 'laravue',
      },
      typePassword: 'password',
      Backgroud: Backgroud,
    };
  },
  computed: {
    language() {
      return this.$store.getters.language;
    },
  },
  beforeCreate: function() {
    document.body.className = 'login';
  },
  methods: {
    doLogin() {
      if (validEmail(this.loginForm.email)) {
        getCSRF()
          .then(() => {
            this.$store.dispatch('user/postLogin', this.loginForm)
              .then(() => {
                this.$router.push({ path: '/dashboard/index', query: {}}, onAbort => {});
              });
          });
      } else {
        MakeToast({ variant: 'danger', title: 'Login Fail', content: 'Fail to Login' });
      }
    },
    showPassword() {
      if (this.typePassword === 'password') {
        this.typePassword = 'text';
      } else {
        this.typePassword = 'password';
      }
    },
    handleSetLanguage(lang) {
      this.$i18n.locale = lang;
      this.$store.dispatch('app/setLanguage', lang);
      var title = this.$t('notiChangeLang.title');
      var content = this.$t('notiChangeLang.content');
      MakeToast({ variant: 'success', title: title, content: content });
    },
  },
};
</script>

<style scoped>
/* ===================================== Import Variables ================================== */
@import url(https://fonts.googleapis.com/css?family=Montserrat:300,400,600,700);
@import url(https://fonts.googleapis.com/css?family=Arimo:300,400,400italic,700,700italic);
/* ===================================== Basic CSS ==================================== */
* {
  margin: 0px;
  padding: 0px;
  list-style: none;
}

ul {
  margin-bottom: 0;
  padding-left: 0;
}

.center {
  text-align: center;
}

.left {
  text-align: left;
}

.right {
  text-align: right;
}

.cp {
  cursor: pointer;
}

html, body {
  height: 100%;
}

p {
  margin-bottom: 0px;
  width: 100%;
}

.hid {
  display: none;
}

.top-mar {
  margin-top: 15px;
}

.h-100 {
  height: 100%;
}

::placeholder {
  color: #747f8a !important;
  font-size: 13px;
  opacity: .5 !important;
}

.container-fluid {
  padding: 0px;
  position: absolute;
  top: 150px;
}

h1, h2, h3, h4, h5, h6 {
  color: #545454;
}

.session-title {
  padding: 30px;
  margin: 0px;
  margin-bottom: 20px;
}
  @media screen and (max-width: 767px) {
    .session-title {
      padding: 5px; }
    }

  .session-title h2 {
    width: 100%;
    text-align: center;
    font-weight: 600;
    margin-bottom: 0px;
  }

  .session-title p {
    max-width: 850px;
    text-align: center;
    float: none;
    margin: auto;
    font-size: .9rem;
    margin-top: 6px;
  }

  .session-title span {
    float: right;
    font-style: italic;
  }

.inner-title {
  padding: 20px;
  padding-left: 0px;
  margin: 0px;
  margin-bottom: 10px;
  padding-bottom: 0px;
  border-bottom: 1px solid #ccccccc4;
  display: block;
  padding-right: 0px;
}
  .inner-title h2 {
    width: 100%;
    text-align: center;
    font-size: 1rem;
    font-weight: 600;
    text-align: left;
    border-bottom: 1px solid #863dd9;
    padding-bottom: 10px;
    margin-bottom: 0px;
    width: 300px;
  }
  .inner-title p {
    width: 100%;
    text-align: center;
  }
  .inner-title .btn {
    float: right;
    margin-top: -38px;
    font-weight: 600;
    font-size: .8rem;
  }

.page-nav {
  background-size: 100%;
  padding: 68px;
  text-align: center;
  background-color: #eaeaea;
}
  .page-nav ul {
    float: none;
    margin: auto;
  }
  @media screen and (max-width: 992px) {
    .page-nav {
      background-size: auto; }
    }
  @media screen and (max-width: 767px) {
    .page-nav {
      padding-top: 200px;
      padding-bottom: 40px; }
    }
  @media screen and (max-width: 356px) {
    .page-nav {
      padding-top: 200px;
      padding-bottom: 40px; }
    }

  .page-nav h2 {
    font-size: 28px;
    width: 100%;
    font-weight: 700;
    color: #444;
  }
    @media screen and (max-width: 600px) {
      .page-nav h2 {
        font-size: 26px; }
      }
  .page-nav ul li {
    float: left;
    margin-right: 10px;
    margin-top: 10px;
    font-size: 16px;
    font-size: .93rem;
    font-weight: 600;
    color: #444;
  }
    .page-nav ul li i {
      width: 30px;
      text-align: center;
      color: #444;
    }
    .page-nav ul li a {
      color: #444;
      font-size: .93rem;
      font-weight: 600;
    }

.btn {
  box-shadow: 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
  border-radius: 2px;
}

.form-control:focus {
  box-shadow: none !important;
  border: 1px solid #CCC;
}

.btn-light {
  background-color: #FFF;
  color: #3F3F3F;
}

.collapse.show {
  display: block !important;
}

.form-control:focus {
  box-shadow: none;
  border: 1px solid #CCC;
}

.form-control {
  background-color: #FFF;
  margin-bottom: 20px;
}

.form-control:focus {
  background-color: #FFF;
  border-color: #CCC;
}

.container {
  max-width: 1170px;
}
@media screen and (max-width: 575px) {
  .container {
    padding: 10px 15px;
  }
}

.login-container {
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  background-color: #FFF;
  z-index: 99;
  border-radius: 30px;
}

@media screen and (max-width: 767px) {
    .container-fluid {
        padding: 0px;
        position: absolute;
        top: 30px;
        margin-bottom: 20px;
    }
}

.login-box {
  padding: 80px 50px;
}

.login-box h5 {
    text-align: center;
    margin-bottom: 40px;
    font-size: 30px;
    color: #000;
}

.login-box label {
    padding: 5px;
    font-size: .9rem;
    font-weight: 600;
    margin-bottom: -15px;
    z-index: 99;
    background-color: #FFF;
    width: auto;
    margin-left: 13px;
}

.login-box input {
    border-radius: 5px;
    padding-top: 25px;
    padding-bottom: 22px;
    background-color: #FFF;
    font-weight: 600;
    font-size: 15px;
    padding-left: 15px;
    padding-right: 15px;
}

.login-box p {
    margin-bottom: 10px;
    font-size: .9rem;
}

.login-box p .vgh {
    float: right;
    margin-top: -32px;
    color: #3751fe;
    font-weight: 600;
}

.login-box .login-row .btn {
    font-weight: 600;
    padding-top: 10px;
    padding-bottom: 10px;
}

.login-box .login-row .btn-primary {
    margin-bottom: 20px;

}

.login-box .donroo {
    margin-top: 15px;
    font-size: .9rem;
    text-align: center;
}

button.btn.btn-primary.btn-sm {
  margin-top: 20px;
  width: 100%;
  background-color: tomato;
  border: none;
}

button.btn.btn-primary.btn-sm:hover {
  opacity: 0.8;
}

a {
  color: #3751fe;
  font-weight: 600;
}

.select-lang {
  width: 100%;
  text-align: center;
}

.select-lang > button {
  background-color: tomato;
}

.background {
  overflow: hidden;
  height: 100vh;
}
</style>
