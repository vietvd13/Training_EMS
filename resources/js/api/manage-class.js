import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
  // Get list all course
  urlGETListCourse: template`/course`,
  // Get list all student
  urlGETListTrainee: template`/user/trainee-list`,
  // Get list all class
  urlGETListClass: template`/class`,
  // Get a class
  urlGETOneClass: template`/class/${'id'}`,
  // Post create a new class
  urlPOSTCreateClass: template`/class`,
  // Put update class
  urlPUTUpdateClass: template`/class/${'id'}`,
  // Delete a class
  urlDELETEClass: template`/class/${'id'}`,
};

export function getListCourse(param) {
  return request.getRequest(urlAPI.urlGETListCourse(), param);
}

export function getListTrainee() {
  return request.getRequest(urlAPI.urlGETListTrainee());
}

export function getListClass(param) {
  return request.getRequest(urlAPI.urlGETListClass(), param);
}

export function getOneClass(param) {
  return request.getRequest(urlAPI.urlGETOneClass(param));
}

export function postCreateClass(newClass) {
  return request.postRequest(urlAPI.urlPOSTCreateClass(), newClass);
}

export function putUpdateClass(class_update, id) {
  return request.putRequest(urlAPI.urlPUTUpdateClass(id), class_update);
}

export function deleteClass(id) {
  return request.deleteRequest(urlAPI.urlDELETEClass(id));
}
