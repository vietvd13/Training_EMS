import request from '../utils/request.js'; //
import { template } from './templateURL.js';

const urlAPI = {
  // Create new profile Information
  urlPOSTProfile: template`/users`,
  //  Get a profile Infomation
  urlGETProfile: template`/users/${'user_id'}`,
  // Update profile Infomation
  urlPUTProfile: template`/users/${'user_id'}`,
  // Update password
  urlPUTPassword: template`/update-password/`,
  // update avatar
  urlPOSTAvatar: template`/users/${'user_id'}/?_method=PUT`,
};
/**
 * Validate a full-lowercase string
 * @return {Object}
 * @param {Object} id
 */
export function getProfile(id) {
  return request.getRequest(urlAPI.urlGETProfile({ user_id: id }));
}
/**
 * Validate a full-lowercase string
 * @return {Object}
 * @param {String} id
 * @param {Object} params
 */
export function updatePassword(params) {
  return request.putRequest(urlAPI.urlPUTPassword(), params);
}
/**
 * Validate a full-lowercase string
 * @return {Object}
 * @param {String} id
 * @param {Object} params
 */
export function updateProfile(id, params) {
  return request.putRequest(urlAPI.urlPUTProfile({ user_id: id }), params);
}
/**
 * Validate a full-lowercase string
 * @return {Object}
 * @param {String} id
 * @param {String} params
 */
export function UpdateAvatar(id, params) {
  return request.postRequest(urlAPI.urlPOSTAvatar({ user_id: id }), params);
}
