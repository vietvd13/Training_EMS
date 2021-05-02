import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
  // Get list grade (Trainer)
  urlGETListGradeTrainer: template`/grades`,
  // Get list grade (Trainee)
  urlGETListGradeTrainee: template`/grade`,
};

export function getListGradeTrainer(body, params) {
  if (body !== null) {
    return request.getRequest(urlAPI.urlGETListGradeTrainer(), params);
  }

  return request.getRequest(urlAPI.urlGETListGradeTrainer(), body, params);
}

export function getListGradeTrainee(params) {
  return request.getRequest(urlAPI.urlGETListGradeTrainee(), params);
}
