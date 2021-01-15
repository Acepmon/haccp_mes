import axios from 'axios'
import config from './config'

export default {
    api: 'ccp_esc_yn',

    // Fetch login history datas
    fetch: function (args = {}) {

        // Default parameters
        let params = {
            ...args
        }

        // Return axios promise
        return axios.get(`${config.baseUrl}/${this.api}?${this.prepParams(params)}`)
    },

    // Create url query parameters for API request
    prepParams(data) {
        const ret = [];
        for (let d in data)
            ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
        return ret.join('&');
    }
}