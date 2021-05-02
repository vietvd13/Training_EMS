<template>
  <div>
    <HeaderDashboard />
    <StartTest />
  </div>
</template>

<script>
// Import component
import HeaderDashboard from './Header/index';
import StartTest from './StartTest/index';

export default {
  name: 'Trainee',
  components: {
    HeaderDashboard,
    StartTest,
  },
};
</script>

<style>

</style>
