import { service } from './service';
export default {
  async getRequest(URL) {
    return await service.get(URL);
  },
  async postRequest(URL, BODY) {
    return await service.post(URL, BODY);
  },
  async putRequest(URL, BODY) {
    return await service.put(URL, BODY);
  },
  async deleteRequest(URL) {
    return await service.delete(URL);
  },
};
