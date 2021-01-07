import axios from 'axios'
import config from './config'

export default {
    api: 'haccp_monitor',

    // Fetch login history datas
    ccp_data: function (args = {}) {

        // Default parameters
        let params = {
            ...args
        }

        // Return axios promise
        return axios.get(`${config.baseUrl}/${this.api}/ccp_data?${this.prepParams(params)}`)
    },

    ccp_data_details: function (device_id, args = {}) {

        // Default parameters
        let params = {
            ...args
        }

        // Return axios promise
        return axios.get(`${config.baseUrl}/${this.api}/ccp_data/${device_id}?${this.prepParams(params)}`)
    },

    // Create url query parameters for API request
    prepParams(data) {
        const ret = [];
        for (let d in data)
            ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
        return ret.join('&');
    }
}