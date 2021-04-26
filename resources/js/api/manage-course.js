import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
  // Get list course
  urlGETListCourse: template`/course`,
  // Post create a new course
  urlPOSTCreateCourse: template`/course`,
};

/**
 * Get all list Course
 * @param {Object} param
 * @returns {Object}
 */
export function getListCourse(param) {
  return request.getRequest(urlAPI.urlGETListCourse(), param);
}

/**
 * Create a new Course
 * @param {Object} newCourse
 * @returns {Object}
 */
export function postCreateCourse(newCourse) {
  return request.postRequest(urlAPI.urlPOSTCreateCourse(), newCourse);
}
