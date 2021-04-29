import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
  // Get list trainer
  urlGETListTrainer: template`/user/trainer-list`,
  // Post assign trainer for class
  urlPOSTAssginTrainer: template`/class/assigned-class/${'id'}`,
};

export function getListTrainer() {
  return request.getRequest(urlAPI.urlGETListTrainer());
}

export function assignTrainer(trainer, id) {
  return request.postRequest(urlAPI.urlPOSTAssginTrainer(id), trainer);
}
