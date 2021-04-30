import request from '../utils/request.js';
import { template } from './templateURL.js';

const urlAPI = {
  // Get list quiz
  urlGETListQuiz: template`/question`,
  // Create a new quiz
  urlPOSTCreateQuiz: template`/question`,
  // Update a quiz
  urlPUTUpdateQuiz: template`/question/${'id'}`,
  // Delete a quiz
  urlDELETEQuiz: template`/question/${'id'}`,
};

export function getListQuiz(param) {
  return request.getRequest(urlAPI.urlGETListQuiz(), param);
}

export function postCreateQuiz(newQuiz) {
  return request.postRequest(urlAPI.urlPOSTCreateQuiz(), newQuiz);
}

export function putUpdateQuiz(quiz, id) {
  return request.putRequest(urlAPI.urlPUTUpdateQuiz(id), quiz);
}

export function deleteQuiz(id) {
  return request.deleteRequest(urlAPI.urlDELETEQuiz(id));
}
