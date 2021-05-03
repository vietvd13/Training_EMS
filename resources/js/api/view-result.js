import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
  // Get list grade (Trainer)
  urlGETListGradeTrainer: template`/grades`,
  // Get list grade (Trainee)
  urlGETListGradeTrainee: template`/grade`,
  // Get list class
  urlGETListClass: template`/user/class-list/${'id'}`,
  // Get list course
  urlGETListCourse: template`/course`,
  // Get list test
  urlGETListTest: template`/test`,
};

export function getListGradeTrainer(params) {
  return request.getRequest(urlAPI.urlGETListGradeTrainer(), params);
}

export function getListGradeTrainee(params) {
  return request.getRequest(urlAPI.urlGETListGradeTrainee(), params);
}

export function getListClass(params) {
  return request.getRequest(urlAPI.urlGETListClass(params));
}

export function getListCourse(params) {
  return request.getRequest(urlAPI.urlGETListCourse(), params);
}

export function getListTest(params) {
  return request.getRequest(urlAPI.urlGETListTest(), params);
}
