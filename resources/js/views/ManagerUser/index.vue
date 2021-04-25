<template>
  <div style="margin-top: 20px;">
    <div class="zone-header-page">
      <b-row>
        <b-col sm="4">
          <div class="zone-controls">
            <b-button>{{ $t('views.manager-user.create-new') }}</b-button>
          </div>
        </b-col>
        <b-col sm="5" />
        <b-col sm="3">
          <div class="zone-controls">
            <b-form-input v-model="keySearch" :placeholder="$t('views.manager-user.enter-search')" />
          </div>
        </b-col>
      </b-row>
    </div>

    <div class="zone-table">
      <div class="card">
        <div class="card-body">
          <div class="zone-display-table">
            <p>table</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ManagerUser',
  data() {
    return {
      keySearch: '',
    };
  },
};
</script>

<style lang="scss" scoped>
  .zone-header-page {
    .zone-controls {
      margin-bottom: 20px;

      button {
        min-width: 150px;
        background-color: #fb8c00;
        border: none;
      }
    }
  }

  .zone-table {
    .zone-display-table {
      width: 100%;
      height: 730px;
      overflow-y: scroll;
    }
  }
</style>
