// This is an example of an API, please create a new one
import request from '../utils/request.js'; //
import { template } from './templateURL.js';

const urlAPI = {
  // Csrf
  urlGETCsrf: template`/csrf-cookie`,
  // Login
  urlPOSTLogin: template`/login`,
  // Get Infor
  urlGETInfo: template`/user`,
  // Logout
  urlPOSTLogout: template`/logout`,
};

/**
 * Validate a full-lowercase string
 * @return {Object}
 */
export function getCSRF() {
  return request.getRequest(
    urlAPI
      .urlGETCsrf());
}

/**
 * Validate a full-lowercase string
 * @return {Object}
 * @param {Object} account
 */
export function postLogin(account) {
  return request.postRequest(
    urlAPI
      .urlPOSTLogin(), account);
}

/**
 * Validate a full-lowercase string
 * @return {Object}
 */
export function getInfo() {
  return request.getRequest(
    urlAPI
      .urlGETInfo());
}

/**
 * Validate a full-lowercase string
 * @return {Object}
 */

export function logout() {
  return request.postRequest(
    urlAPI
      .urlPOSTLogout());
}
