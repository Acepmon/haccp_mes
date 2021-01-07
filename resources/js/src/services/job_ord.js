import axios from 'axios'
import config from './config'

export default {
    api: 'job_ord',

    // Fetch login history datas
    fetch: function (args = {}) {

        // Default parameters
        let params = {
            page: 1,
            limit: 15,
            sort: 'JOB_DT',
            order: 'ASC',
            with: 'item',
            ...args
        }

        // Return axios promise
        return axios.get(`${config.baseUrl}/${this.api}?${this.prepParams(params)}`)
    },

    summary_details: function (args = {}) {

        // Default parameters
        let params = {
            page: 1,
            limit: 15,
            sort: 'JOB_DT',
            order: 'ASC',
            with: 'item',
            ...args
        }

        // Return axios promise
        return axios.get(`${config.baseUrl}/${this.api}/summary_details?${this.prepParams(params)}`)
    },

    post: function (formData) {
        return axios.post(`${config.baseUrl}/${this.api}`, formData, {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
    },

    put: function (id, formData) {

        // Default parameters
        formData.append('_method', 'PUT')

        return axios.post(`${config.baseUrl}/${this.api}/${id}`, formData, {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
    },

    delete: function (id, args = {}) {

        // Default parameters
        let params = {
            _method: 'DELETE',
            ...args
        }

        return axios.post(`${config.baseUrl}/${this.api}/${id}`, params)
    },

    sync: function (args = {}) {
        // Default parameters
        let params = {
            ...args
        }

        // Return axios promise
        return axios.post(`${config.baseUrl}/${this.api}/sync`, params)
    },

    export: function (params) {
        return `${config.baseUrl}/${this.api}/export?${this.prepParams(params)}`
    },

    summary_export: function (params) {
        return `${config.baseUrl}/${this.api}/summary_export?${this.prepParams(params)}`
    },

    import: function (formData) {
        return axios.post(`${config.baseUrl}/${this.api}/import`, formData, {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
    },

    // Create url query parameters for API request
    prepParams(data) {
        const ret = [];
        for (let d in data)
            ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
        return ret.join('&');
    }
}