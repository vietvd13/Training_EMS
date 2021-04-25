import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
  // Get list user
  urlGETListUser: template`/users`,
  // Post create a new user
  urlPOSTCreateUser: template`/users`,
  // Put update a user
  urlPUTUpdateUser: template`/users/${'id'}`,
  // Delete a user
  urlDELETEUser: template`/users/${'id'}`,
};

/**
 * Get all list User
 * @param {param}
 * @returns {Object}
 */
export function getListUser(param) {
  return request.getRequest(urlAPI.urlGETListUser(), param);
}

/**
 * Create a new User
 * @param {Object} newUser
 * @returns {Object}
 */
export function postCreateUser(newUser) {
  return request.postRequest(urlAPI.urlPOSTCreateUser(), newUser);
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

/**
 * Delete a User
 * @param {Object} pram
 * @returns {Object}
 */
export function deleteUser(pram) {
  return request.deleteRequest(urlAPI.urlDELETEUser(pram));
}

