import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
  // Get list full class
  urlGETListFullClass: template`/user/class-list/${'id'}`,
};

export function getListFullClass(id_user) {
  return request.getRequest(urlAPI.urlGETListFullClass(id_user));
}

