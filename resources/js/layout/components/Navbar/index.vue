<template>
  <b-navbar toggleable="lg" type="dark">

    <b-navbar-brand @click.prevent.stop="$emit('toggle')">
      <i id="toggle-menu" class="icofont-navigation-menu" />
    </b-navbar-brand>

    <b-navbar-toggle target="nav-collapse">
      <template #default="{ expanded }">
        <b-icon v-if="expanded" icon="chevron-bar-up" />
        <b-icon v-else icon="chevron-bar-down" />
      </template>
    </b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav id="text-name">
        {{ $t(title) }}
      </b-navbar-nav>

      <b-navbar-nav class="ml-auto">

        <LangSelector class="m-2" />

        <b-dropdown text="Block Level Dropdown" block class="m-2">
          <template #button-content>
            <b-icon icon="person-circle" font-scale="1.0" class="icon-user" /><span>{{ $t('navbar.usersettings') }}</span>
          </template>
          <b-dropdown-item class="text" :disabled="routePath==='/dashboard/profile'" @click="$router.push('/dashboard/profile')">
            {{ $t('profile.title') }}
          </b-dropdown-item>
          <b-dropdown-item class="text">Settings</b-dropdown-item>
          <b-dropdown-item class="text" @click="logout">Logout</b-dropdown-item>
        </b-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>

<script>
import LangSelector from '../LangSelector/index';

export default {
  name: 'Navbar',
  components: {
    LangSelector,
  },
  data() {
    return {
      title: this.$route.meta.title,
    };
  },
  computed: {
    routeChange() {
      return this.$route;
    },
    routePath() {
      return this.$route.path;
    },
  },
  watch: {
    routeChange() {
      this.title = this.$route.meta.title;
    },
  },
  methods: {
    async logout() {
      await this.$store.dispatch('user/logout');
      this.$router.push(`/login?redirect=${this.$route.fullPath}`);
    },
  },
};
</script>

<style>
.navbar{
    background-color: #fff;
    border-bottom: 1px solid #dee4ec;
    width: 100%;
    top: 0;
    position: sticky;
    z-index: 999;
}

.navbar .nav-link{
    color: #5b6e88 !important;
}

.navbar a i{
    color: #5b6e88;
    font-size: 20px;
}

@media(max-width: 768px){
    .navbar-dark .navbar-toggler {
        border-color:transparent;
    }
}

#text-name {
    font-size: 21px;
}

.text a {
    color: black;
    text-decoration: none;
}

#selectStore {
    width: 200px;
}

#selectApp {
    width: 250px;
    margin-right: 10px;
}

.icon-user {
  margin-right: 5px;
}

.item-nav {
  margin-left: 10px;
  margin-right: 10px;
}

.display-full {
  display: flex;
}

i#toggle-menu {
  color: #000;
}

button.navbar-toggler {
  background: #052C50 99%;
}

button.navbar-toggler > svg {
  color: white;
}

button.navbar-toggler:focus {
  outline: none;
}

</style>

