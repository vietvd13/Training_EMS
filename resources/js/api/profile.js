import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
  // Get a profile
  urlGETProfile: template`/users`,
};

/**
 * Get a profile
 * @param {Object} user
 * @returns {Object}
 */
export function getProfile(user) {
  return request.getRequest(urlAPI.urlGETProfile(), user);
}

