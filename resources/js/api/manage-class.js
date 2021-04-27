import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
  // Get list all course
  urlGETListCourse: template`/course`,
  // Get list all student
  urlGETListTrainee: template`/user`,
  // Post create a new class
  urlPOSTCreateClass: template`/class`,
  // Put update class
  urlPUTUpdateClass: template`/class/${'id'}`,
  // Delete a class
  urlDELETEClass: template`/class/${'id'}`,
};

export function getListCourse(pram) {
  return request.getRequest(urlAPI.urlGETListCourse(), pram);
}

export function getListTrainee() {
  return request.getRequest(urlAPI.urlGETListTrainee());
}

export function postCreateClass() {
  return request.postRequest(urlAPI.urlPOSTCreateClass());
}

export function putUpdateClass() {
  return request.putRequest(urlAPI.urlPUTUpdateClass());
}

export function deleteClass() {
  return request.deleteRequest(urlAPI.urlDELETEClass());
}
