import axios from 'axios'
import config from './config'

export default {
    api: 'ccp_data',

    fetch: function (args = {}) {

        // Default parameters
        let params = {
            ...args
        }

        // Return axios promise
        return axios.get(`${config.baseUrl}/${this.api}?${this.prepParams(params)}`)
    },

    dashboard: function (args = {}) {

        // Default parameters
        let params = {
            ...args
        }

        // Return axios promise
        return axios.get(`${config.baseUrl}/${this.api}/dashboard?${this.prepParams(params)}`)
    },

    export: function (params) {
        return `${config.baseUrl}/${this.api}/export?${this.prepParams(params)}`
    },

    details: function (device_id, args = {}) {

        // Default parameters
        let params = {
            ...args
        }

        // Return axios promise
        return axios.get(`${config.baseUrl}/${this.api}/${device_id}?${this.prepParams(params)}`)
    },

    // Create url query parameters for API request
    prepParams(data) {
        const ret = [];
        for (let d in data)
            ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
        return ret.join('&');
    }
}