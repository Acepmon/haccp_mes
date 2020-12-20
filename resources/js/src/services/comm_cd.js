import axios from 'axios'
import config from './config'

export default {
    api: 'code',

    // Fetch comm_cd datas
    fetch: function (args = {}) {

        // Default parameters
        let params = {
            ...args
        }

        // Return axios promise
        return axios.get(`${config.baseUrl}/${this.api}?${this.prepParams(params)}`)
    },

    get: function (args = {}) {
        // Default parameters
        let params = {
            ...args
        }

        // Return axios promise
        return axios.get(`${config.baseUrl}/comm_cd?${this.prepParams(params)}`)
    },

    sync: function (comm1_cd, args = {}) {
        // Default parameters
        let params = {
            ...args
        }

        // Return axios promise
        return axios.post(`${config.baseUrl}/comm_cd/${comm1_cd}/sync`, params)
    },

    // Create url query parameters for API request
    prepParams(data) {
        const ret = [];
        for (let d in data)
            ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
        return ret.join('&');
    }
}