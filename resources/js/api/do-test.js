import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
  // Get One Test
  urlGETOneTest: template`/test/${'id'}`,
  // Post Submit Test
  urlPOSTSubmitTest: template`/testing/submit`,
};

export function getOnTest(id_test) {
  return request.getRequest(urlAPI.urlGETOneTest(id_test));
}

export function postSubmitTest(answer) {
  return request.postRequest(urlAPI.urlPOSTSubmitTest(), answer);
}
