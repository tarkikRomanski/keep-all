import axios from 'axios';

export default class Resource {
    getApiUrl(slug, prefix = 'api/1.0') {
        let protocol = location.protocol;
        let slashes = protocol.concat("//");
        let host = slashes.concat(window.location.hostname);
        return host + '/' + prefix + (prefix ? '/' : '') + slug;
    }

    post(url, data, config = {}) {
        return axios.post(this.getApiUrl(url), data, config);
    }

    delete(url) {
        return axios.delete(this.getApiUrl(url))
    }

    get(url) {
        return axios.get(this.getApiUrl(url));
    }
}