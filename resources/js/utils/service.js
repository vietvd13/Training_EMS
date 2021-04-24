import axios from 'axios';
import { MakeToast } from './toast_message';
import i18n from '../lang/index';

const baseURL = process.env.MIX_BASE_API;

const service = axios.create({
  baseURL: baseURL,
  timeout: 10000,
});
service.interceptors.request.use(
  config => {
    return config;
  },
  error => {
    Promise.reject(error);
  }
);
service.interceptors.response.use(
  response => {
    return response.data;
  },
  error => {
    const titleErr = error.response.data.title || 'axios.err.title';
    const contentErr = error.response.data.message;

    const isCheckTitle = i18n.te(titleErr);
    const isCheckContent = i18n.te(contentErr);

    var title;
    var content;

    const STATUS_DEBUG = true;

    if (isCheckTitle && isCheckContent) {
      title = i18n.t(titleErr);
      content = i18n.t(contentErr);

      MakeToast({
        variant: 'danger',
        title: title,
        content: content,
        toaster: 'b-toaster-top-right',

      });
    } else {
      if (STATUS_DEBUG === true) {
        title = i18n.t(titleErr) || i18n.t('axios.err.title');
        content = i18n.t(contentErr) || i18n.t('axios.err.content');

        console.log('【❌ - ERROR - ❌】');
        console.log(title);
        console.log(content);
        console.log('【❌ - -END- - ❌】');
      }
    }

    return Promise.reject(error);
  }
);
export { service };
