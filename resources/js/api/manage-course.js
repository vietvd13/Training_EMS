import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
  // Get list course
  urlGETListCourse: template`/course`,
  // Post create a new course
  urlPOSTCreateCourse: template`/course`,
  // Put update a course
  urlPUTUpdateCourse: template`/course/${'id'}`,
  // Delete a course
  urlDELETECourse: template`/course/${'course_id'}`,
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

/**
 * Update a Course
 * @param {Object} course
 * @param {Object} id
 * @returns {Object}
 */
export function putUpdateCourse(course, id) {
  return request.putRequest(urlAPI.urlPUTUpdateCourse(id), course);
}

/**
 * Delete a Course
 * @param {Object} id
 * @returns {Object}
 */
export function deleteCourse(id) {
  return request.deleteRequest(urlAPI.urlDELETECourse(id));
}
