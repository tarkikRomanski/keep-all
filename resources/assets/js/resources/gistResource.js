import axios from 'axios';

const privateElements = {
    _getUrl(action, token = true) {
        let accessToken = token ? `?access_token=${this._personalToken}` : '';
        return `${this._gistUrl}${this._userName}/${action}${accessToken}`;
    },
    _personalToken: '5fc4de785452f66293e57078b2b2701834968e47',
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

    create(data, succes, error = null) {
        queryOptions = {
            headers: {
              'Authorization': `token ${privateElements._personalToken}`,
              'Content-Type': 'application/json'
            }
        };

        let url = privateElements._getUrl('gists', false);
        return axios.post(url, data, queryOptions)
            .then(succes)
            .catch(error);
    }
}