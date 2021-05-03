import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
  // Get list full class
  urlGETListTest: template`/test`,
};

export function getListTest(params) {
  return request.getRequest(urlAPI.urlGETListTest(), params);
}

