import axios from 'axios';

class HttpService {
    constructor() {
        if (HttpService.instance) {
            return HttpService.instance;
        }

        HttpService.instance = this;
    }

    get(url, options) {
        return axios.get(url, options);
    }

    post(url, body, options) {
        return axios.post(url, body, options);
    }

    put(url, body, options) {
        return axios.put(url, body, options);
    }

    delete(url, options) {
        return axios.delete(url, options);
    }
}

export default new HttpService();
