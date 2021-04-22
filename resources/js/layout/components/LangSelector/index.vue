<template>
  <!-- Start Dropdown -->
  <b-dropdown text="Block Level Dropdown" block>
    <!-- Icon change -->
    <template #button-content>
      <b-icon icon="globe" font-scale="1.0" class="icon-globe" /><span>{{ $t('views.login.changelang') }}</span>
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
</template>

<script>
import { MakeToast } from '@/utils/toast_message';
export default {
  computed: {
    language() {
      return this.$store.getters.language;
    },
  },
  methods: {
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
.icon-globe {
  margin-right: 5px;
}
</style>
