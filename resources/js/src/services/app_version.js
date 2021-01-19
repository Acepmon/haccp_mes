import axios from 'axios'
import config from './config'

export default {
    api: 'app_version',

    // Fetch login history datas
    fetch: function (args = {}) {

        // Default parameters
        let params = {
            ...args
        }

        // Return axios promise
        return axios.get(`${config.baseUrl}/${this.api}?${this.prepParams(params)}`)
    },

    put: function (args = {}) {

        // Default parameters
        let params = {
            _method: 'PUT',
            ...args
        }

        return axios.post(`${config.baseUrl}/${this.api}`, params)
    },

    // Create url query parameters for API request
    prepParams(data) {
        const ret = [];
        for (let d in data)
            ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
        return ret.join('&');
    }
}