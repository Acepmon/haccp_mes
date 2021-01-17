import axios from 'axios'
import config from './config'

export default {
    api: 'job_ord_dtl_work',

    // Fetch login history datas
    fetch: function (args = {}) {

        // Default parameters
        let params = {
            page: 1,
            limit: 15,
            sort: 'JOB_NO',
            order: 'DESC',
            with: '',
            ...args
        }

        // Return axios promise
        return axios.get(`${config.baseUrl}/${this.api}?${this.prepParams(params)}`)
    },

    post: function (args = {}) {

        // Default parameters
        let params = {
            ...args
        }

        return axios.post(`${config.baseUrl}/${this.api}`, params)
    },

    put: function (id, args = {}) {

        // Default parameters
        let params = {
            _method: 'PUT',
            ...args
        }

        return axios.post(`${config.baseUrl}/${this.api}/${id}`, params)
    },

    delete: function (id, args = {}) {

        // Default parameters
        let params = {
            _method: 'DELETE',
            ...args
        }

        return axios.post(`${config.baseUrl}/${this.api}/${id}`, params)
    },

    download: function () {

        // Default parameters
        let params = {
            responseType: 'blob'
            // headers: {
            //     'Accept': 'application/xls'
            // }
        }

        return axios.get(`${config.baseUrl}/${this.api}/download`, params)
    },

    downloadUrl: function () {
        return `${config.baseUrl}/${this.api}/download`
    },

    // Create url query parameters for API request
    prepParams(data) {
        const ret = [];
        for (let d in data)
            ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
        return ret.join('&');
    }
}