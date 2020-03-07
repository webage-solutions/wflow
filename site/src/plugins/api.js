import axios from "axios";
import router from "../router";

export default {
    install: function (Vue) {
        Vue.prototype.$api = {
            baseUrl: process.env.VUE_APP_API_URL,
            httpClient: null,

            // inits the axios instance httpClient (with logged token)
            init: function () {
                this.httpClient = axios.create({
                    baseURL: this.baseUrl + '/',
                    headers: {'Authorization': `Bearer ${localStorage.getItem('access_token')}`}
                });
            },

            // global request method, that ensures the axios instance before requesting through it
            request: function (method, url, data, params) {

                url = `${this.baseUrl}/${url}`;

                const headers = {};

                // get the access token
                const accessToken = localStorage.getItem('access_token');
                if (accessToken) {
                    headers['Authorization'] = `Bearer ${accessToken}`;
                }

                // get the organization id
                const organizationId = localStorage.getItem('organizationId');
                if (organizationId) {
                    headers['X-Wflow-Organization'] = organizationId;
                }

                return new Promise((resolve, reject) => {
                    axios.request({
                        method, url, data, params, headers
                    }).then(response => {
                        resolve(response)
                    }).catch(error => {
                        // handle 401 - Unauthorized
                        if (error.response.status === 401) {

                            // if there is no refresh token, go to login
                            if (localStorage.getItem('refresh_token') === null) {
                                router.push('login');
                                return;
                            }

                            // try to refresh the token
                            this.refreshLogin().then(() => {

                                // token refreshed - retry the request
                                const retryConfig = error.response.config;
                                retryConfig.headers.Authorization = `Bearer ${localStorage.getItem('access_token')}`;
                                axios.request(retryConfig).then(response => {
                                    resolve(response);
                                }).catch(() => {
                                    router.push('login');
                                });

                            }).catch(() => {

                                // refresh failed - remove the tokens and go to login
                                this.purgeAuth();
                                router.push('login');

                            });

                        } else {
                            reject(error);
                        }
                    });
                });
            },

            addTokenToUrl: function(url) {
                const token = localStorage.getItem('access_token');
                if (token && url) {
                    return url + (url.match(/\?[^=]+=./) ? '&' : '?') + `token=${token}`;
                }
                return url;
            },


            refreshLogin: function() {
                return new Promise((resolve, reject) => {
                    axios.request({
                        method: 'post',
                        url: this.baseUrl + '/' + 'refresh-login',
                        data: {
                            refresh_token: localStorage.getItem('refresh_token')
                        }
                    }).then(response => {
                        localStorage.setItem('access_token', response.data.access_token);
                        localStorage.setItem('refresh_token', response.data.refresh_token);
                        this.httpClient = null;
                        resolve();
                    }).catch(() => {
                        reject();
                    });
                });
            },

            uiColors: function () {
                return this.request('get', 'ui/colors');
            },
            organizationByDomain: function(domain) {
                return this.request('get', `organizations/${domain}`);
            },
            organizationsIndex: function (query) {
                return this.request('get', 'organizations', null, query);
            },
            profile: function () {
                return this.request('get', 'profile');
            }
        };
    }
};