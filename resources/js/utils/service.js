import axios from 'axios';
import { MakeToast } from './toast_message';

const baseURL = process.env.MIX_BASE_API;

const service = axios.create({
  baseURL: baseURL,
  timeout: 10000,
});
service.interceptors.request.use(
  config => {
    // const token = isLogged();
    // if (token) {
    //   config.headers['Authorization'] = 'Bearer ' + isLogged(); // Set JWT token
    // }
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
    MakeToast({
      variant: 'danger',
      title: 'Error API',
      content: 'Add user failed',
      toaster: 'b-toaster-bottom-center',

    });
    return Promise.reject(error);
  }
);
export { service };
