// This is an example of an API, please create a new one
import request from '../utils/request.js'; //
import { template } from './templateURL.js';

const urlAPI = {
  // Create new Meeting Information
  urlPOSTMeeting: template`/meetings`,
  //  Get a Meeting Infomation
  urlGETMeeting: template`/meetings/${'meeting_id'}`,
  // Update Meeting Infomation
  urlPUTMeeting: template`/meetings/${'meeting_id'}`,
  // Delete partisipant belong to {meeting_id}
  urlDELETEMeetingSingleParticipant:
            template`/meetings/${'meeting_id'}/participants/${'email'}`,
};
/**
 * Validate a full-lowercase string
 * @return {Object}
 * @param {Object} params
 */
export function createMeeting(params) {
  return request.postRequest(urlAPI.urlPOSTMeeting(), params);
}
/**
 * Validate a full-lowercase string
 * @return {Object}
 * @param {String} id
 */
export function getMeeting(id) {
  return request.getRequest(urlAPI.urlGETMeeting({ meeting_id: id }));
}
/**
 * Validate a full-lowercase string
 * @return {Object}
 * @param {String} id
 * @param {Object} params
 */
export function updateMeeting(id, params) {
  return request.putRequest(urlAPI.urlPUTMeeting({ meeting_id: id }), params);
}

/**
 * Validate a full-lowercase string
 * @return {Object}
 * @param {String} id
 * @param {String} email
 */
export function deleteParticipant(id, email) {
  return request.deleteRequest(
    urlAPI
      .urlDELETEMeetingSingleParticipant({ meeting_id: id, email: email }));
}
