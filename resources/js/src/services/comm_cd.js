import axios from 'axios'
import config from './config'

export default {
    api: 'comm_cd',

    // Fetch comm_cd datas
    fetch: function (args = {}) {

        // Default parameters
        let params = {
            page: 1,
            limit: 15,
            ...args
        }

        // Return axios promise
        return axios.get(`${config.baseUrl}/${this.api}?${this.prepParams(params)}`)
    },

    fetchRoles: function (args = {}) {

        // Default parameters
        let params = {
            page: 1,
            limit: 15,
            ...args
        }

        return axios.get(`${config.baseUrl}/${this.api}/roles?${this.prepParams(params)}`)
    },

    fetchApprovals: function (args = {}) {

        // Default parameters
        let params = {
            page: 1,
            limit: 15,
            ...args
        }

        return axios.get(`${config.baseUrl}/${this.api}/approvals?${this.prepParams(params)}`)
    },

    fetchJobs: function (args = {}) {

        // Default parameters
        let params = {
            page: 1,
            limit: 15,
            ...args
        }

        return axios.get(`${config.baseUrl}/${this.api}/jobs?${this.prepParams(params)}`)
    },

    // Create url query parameters for API request
    prepParams(data) {
        const ret = [];
        for (let d in data)
            ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
        return ret.join('&');
    }
}