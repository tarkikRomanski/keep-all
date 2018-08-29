import axios from 'axios';

const privateElements = {
    _getUrl(action) {
        return `${this._gistUrl}${this._userName}/${action}?access_token=${this._personalToken}`;
    },
    _personalToken: 'd1bbad93118cb2b1dd68a8d4236fe60edb98009b',
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