import axios from 'axios';
import swal from 'sweetalert2'

const privateElements = {
    _getGistsListUrl() {
        return `${this._gistsListUrl}${this._userName}/gists?access_token=${this._personalToken}`;
    },
    _personalToken: '5fc4de785452f66293e57078b2b2701834968e47',
    _userName: 'tarkikRomanski',
    _gistsListUrl: 'https://api.github.com/users/',
    _queryUrl: 'https://api.github.com/gists'
}

export default class GistResource {
    list(succes, error = null) {
        window.axios.defaults.headers.common['Authorization'] = null;

        let url = privateElements._getGistsListUrl();
        return axios.get(url)
            .then(succes)
            .catch(error);
    }  

    create(data, error = null) {
        const queryOptions = {
            headers: {
              'Authorization': `token ${privateElements._personalToken}`,
              'Content-Type': 'application/json'
            }
        };

        return axios.post(privateElements._queryUrl, data, queryOptions)
            .then(response => {
                if (response.status == 201) {
                    swal(
                        'New gist has been created!',
                        'You are created the new gist',
                        'success'
                    );
                }
            })
            .catch(error);
    }

    delete(id, succes = null, error = null) {
        const queryOptions = {
            headers: {
              'Authorization': `token ${privateElements._personalToken}`
            }
        };

        return axios.delete(`${privateElements._queryUrl}/${id}`, queryOptions)
            .then(response => {
                if (response.status == 204) {
                    swal(
                        'Gist has been deleted!',
                        `You are deleted the gist (${id})`,
                        'success'
                    );

                    return true;
                }
            })
            .catch(error);
    }
}