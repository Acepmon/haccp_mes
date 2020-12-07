import axios from 'axios'
import config from './config'

export default {
    api: 'login_hist',

    // Fetch login history datas
    fetch: function (args = {}) {

        // Default parameters
        let params = {
            page: 1,
            limit: 15,
            sort: 'login_dtm',
            order: 'asc',
            from: '',
            to: '',
            keyword: '',
            with: 'user',
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