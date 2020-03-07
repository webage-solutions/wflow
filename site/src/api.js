import axios from "axios";
import store from "./store";
import router from "./router";
const api = {

    baseURL: process.env.VUE_APP_API_URL,

    httpClient: function() {

        // base config
        const config = {
            baseURL: `${this.baseURL}/api`,
            headers: {},
        };

        // add auth token
        if (store.state.oauthToken) {
            config.headers['Authorization'] = `Bearer ${store.state.oauthToken.access_token}`;
        }

        // add organization
        // if (store.state.organization) {
        //     config.headers['X-Wflow-Organization'] = store.state.organization.id;
        // }

        const httpClient = axios.create(config);

        // response interceptor
        httpClient.interceptors.response.use(
            response => response,
            error => {
                switch (error.response.status) {
                    // case 401: // Unauthorized
                    //     // TODO - handle refresh
                    //     store.commit('logout');
                    //     router.push('/login');
                    //     break;
                    // case 403: // Forbidden
                    //     // TODO
                    //     break;
                }
                return Promise.reject(error);
            }
        );

        return httpClient;
    },

    organizationByDomain: function(domain) {
        return this.httpClient().get(`organizations/${domain}/public`);
    },

    login: function (username, password) {
        return new Promise((resolve, reject) => {
            const data = {username, password};
            this.httpClient().post('login', data)
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error);
                });
        });
    },

    logout: function() {

        // first revoke the token on backend (async notify)
        const promise =  this.httpClient().post('logout');

        // then drop the token from vuex (local)
        store.commit('logout');

        // return the promise to the caller
        return promise;
    },

    profile: function() {
        return this.httpClient().get('profile');
    }
};

export default api;