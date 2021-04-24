import { service } from './service';

export default {
  async getRequest(URL, PARAMS) {
    return await service({
      url: URL,
      method: 'GET',
      params: PARAMS,
    });
  },

  async postRequest(URL, DATA, PARAMS) {
    return await service({
      url: URL,
      method: 'POST',
      data: DATA,
      params: PARAMS,
    });
  },

  async putRequest(URL, DATA, PARAMS) {
    return await service({
      url: URL,
      method: 'PUT',
      data: DATA,
      params: PARAMS,
    });
  },

  async deleteRequest(URL, DATA, PARAMS) {
    return await service({
      url: URL,
      method: 'DELETE',
      data: DATA,
      params: PARAMS,
    });
  },
};
