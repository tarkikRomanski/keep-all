import axios from 'axios';

const privateElements = {
    _getUrl(action) {
        return `${this._gistUrl}${this._userName}/${action}?access_token=${this._personalToken}`;
    },
    _personalToken: '8f55604f30fd48a5c31e8443805d32e44b231f47',
    _userName: 'tarkikRomanski',
    _gistUrl: 'https://api.github.com/users/'
}

export default class GistResource {
    list(succes, error = null) {
        window.axios.defaults.headers.common['Authorization'] = null;

        let url = privateElements._getUrl('gists');
        return axios.get(url)
            .then(succes)
            .catch(error);
    }  
}