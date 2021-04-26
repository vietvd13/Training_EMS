<template>
  <div>
    <div style="margin-top: 20px">
      <component :is="currentView()" />
    </div>
  </div>
</template>

<script>
// Import component
import Administrator from '@/views/Dashboard/components/Administrator';
import Trainee from '@/views/Dashboard/components/Trainee';
import Trainers from '@/views/Dashboard/components/Trainers';
import TrainingStaff from '@/views/Dashboard/components/TrainingStaff';

// Import Const
import CONST_VALUE from '../../../../const/const_value.json';

export default {
  name: 'Dashboard',
  components: {
    Administrator,
    Trainee,
    Trainers,
    TrainingStaff,
  },
  data() {
    return {
      CONST_VALUE: CONST_VALUE,
    };
  },
  methods: {
    currentView() {
      const listRole = this.$store.getters.roles;

      if (listRole.length > 0) {
        const ROLE = listRole[0];

        switch (ROLE) {
          case CONST_VALUE.ROLE.ADMIN:
            return CONST_VALUE.DASHBOARD_VIEW.ADMIN;
          case CONST_VALUE.ROLE.TRAINEE:
            return CONST_VALUE.DASHBOARD_VIEW.TRAINEE;
          case CONST_VALUE.ROLE.TRAINERS:
            return CONST_VALUE.DASHBOARD_VIEW.TRAINERS;
          case CONST_VALUE.ROLE.TRAINING_STAFF:
            return CONST_VALUE.DASHBOARD_VIEW.TRAINING_STAFF;
          default:
            console.warn('[Viet ERROR]: Lỗi có role những không xác định được role gì!');
        }
      }
    },
  },
};
</script>

<style>

</style>
