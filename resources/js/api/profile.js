import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
  // Get a profile
  urlGETProfile: template`/user/${'id'}`,
  // Put update a user
  urlPUTUpdateUser: template`/users/${'id'}`,
};

/**
 * Get a profile
 * @param {Object} user
 * @returns {Object}
 */
export function getProfile(user) {
  return request.getRequest(urlAPI.urlGETProfile(), user);
}

/**
 * Update Infor User
 * @param {Object} param
 * @param {Object} user
 * @returns
 */
export function putUpdateUser(user, id) {
  return request.putRequest(urlAPI.urlPUTUpdateUser(id), user);
}

