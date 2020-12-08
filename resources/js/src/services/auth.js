import axios from 'axios'
import config from './config'
import store from '@/store/store'

// 'loggedIn' is used in other parts of application. So, Don't forget to change there also
const localStorageKey = 'loggedIn'

const tokenExpiryKey = 'tokenExpiry'
const loginEvent = 'loginEvent'

export default {
    idToken: null,
    profile: null,
    tokenExpiry: null,

    login: function (user_id, user_pw) {
        let headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        }

        return axios.post(`/login`, {
            'user_id': user_id,
            'user_pw': user_pw
        }, {
            headers: headers
        })
    },

    // Handles the callback request from Auth0
    handleAuthentication () {
        return new Promise((resolve, reject) => {
            webAuth.parseHash((err, authResult) => {
                if (err) {
                    alert(`${err.error}. Detailed error can be found in console.`)
                    reject(err)
                } else {
                    this.localLogin(authResult)
                    resolve(authResult.idToken)
                }
            })
        })
    },

    localLogin (authResult) {
        this.idToken = authResult.idToken
        this.profile = authResult.idTokenPayload
  
        // Convert the JWT expiry time from seconds to milliseconds
        this.tokenExpiry = new Date(this.profile.exp * 1000)
        localStorage.setItem(tokenExpiryKey, this.tokenExpiry)
        localStorage.setItem(localStorageKey, 'true')
  
        store.commit('UPDATE_USER_INFO', {
            displayName: this.profile.name,
            email: this.profile.email,
            photoURL: this.profile.picture,
            providerId: this.profile.sub.substr(0, this.profile.sub.indexOf('|')),
            uid: this.profile.sub
        })
    },

    logOut () {
        localStorage.removeItem(localStorageKey)
        localStorage.removeItem(tokenExpiryKey)
        localStorage.removeItem('userInfo')
  
        this.idToken = null
        this.tokenExpiry = null
        this.profile = null

        let headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': this.getToken()
        }

        return axios.post(`${config.baseUrl}/auth/logout`, {
            'user_id': user_id,
            'user_pw': user_pw
        }, {
            headers: headers
        })
    },

    isAuthenticated () {
        return (
          new Date(Date.now()) < new Date(localStorage.getItem(tokenExpiryKey)) &&
              localStorage.getItem(localStorageKey) === 'true'
        )
    },

    // Create url query parameters for API request
    prepParams(data) {
        const ret = [];
        for (let d in data)
            ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
        return ret.join('&');
    }
}