import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
  // Get list class
  urlGETListClass: template`/class`,
  // Get list course
  urlGETListCourse: template`/course`,
  // Get List Quiz
  urlGETListQuiz: template`/question`,
  // Get list test
  urlGETListTest: template`/test`,
  // Post create a new test
  urlPOSTCreateTest: template`/test`,
  // Put update a test
  urlPUTUpdateTest: template`/test/${'id'}`,
  // Delete a test
  urlDELETETest: template`/test/${'id'}`,
};

export function getListClass(param) {
  return request.getRequest(urlAPI.urlGETListClass(), param);
}

export function getListCourse(param) {
  return request.getRequest(urlAPI.urlGETListCourse(), param);
}

export function getListQuiz(param) {
  return request.getRequest(urlAPI.urlGETListQuiz(), param);
}

export function getListTest(param) {
  return request.getRequest(urlAPI.urlGETListTest(), param);
}

export function postCreateTest(newTest) {
  return request.postRequest(urlAPI.urlPOSTCreateTest(), newTest);
}

export function putUpdateTest(test, id) {
  return request.putRequest(urlAPI.urlPUTUpdateTest(id), test);
}

export function deleteTest(id) {
  return request.deleteRequest(urlAPI.urlDELETETest(id));
}
