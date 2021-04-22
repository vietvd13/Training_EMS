<template>
  <div id="wrapper" :class="toggle">
    <Sidebar />
    <div id="page-content-wrapper">
      <Navbar @toggle="toggleMenu()" />
      <div class="container-fluid dashboard">
        <AppMain />
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from './components/Navbar/index';
import Sidebar from './components/Sidebar/index';
import AppMain from './components/AppMain';

export default {
  name: 'Layout',
  components: {
    AppMain,
    Sidebar,
    Navbar,
  },
  data() {
    return {
      toggle: '',
      toggleBool: false,
    };
  },
  methods: {
    toggleMenu(){
      this.toggleBool = !this.toggleBool;
      if (this.toggleBool === true){
        this.toggle = 'toggled';
      } else {
        this.toggle = '';
      }
    },
  },
};
</script>

<style scoped>
#nav {
    padding: 30px;
}

#nav a {
    font-weight: bold;
    color: #2c3e50;
}

#nav a.router-link-exact-active {
    color: #42b983;
}
</style>
