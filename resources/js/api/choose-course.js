import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
  // Get list full class
  urlGETListFullCourse: template`/class/${'id'}`,
};

export function getListFullCourse(id_class) {
  return request.getRequest(urlAPI.urlGETListFullCourse(id_class));
}
