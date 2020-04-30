import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersistence from 'vuex-persist';
import api from './api';

Vue.use(Vuex);

//const baseDomain = process.env.VUE_APP_BASE_DOMAIN;

// persist everything but auth in localStorage
const vuexLocal = new VuexPersistence({
    storage: window.localStorage,
    // reducer: (state) => {
    //     const clone = Object.assign({}, state);
    //     delete clone.auth;
    //     return clone;
    // },
    // filter: (mutation) => !['setAuth', 'logout'].includes(mutation.type),
});

// persist auth on a cookie
// const vuexCookie = new VuexPersistence({
//     restoreState: (key) => Cookies.getJSON(key),
//     saveState: (key, state) =>
//         Cookies.set(key, state, {
//             expires: 360,
//             domain: baseDomain,
//         }),
//     reducer: ({auth}) => ({auth}),
//     filter: (mutation) => ['setAuth', 'logout'].includes(mutation.type)
// });

const store = new Vuex.Store({
    state: {
        organization: null,
        oauthToken: null,
        oauthInfo: {
            state: null,
            codeVerifier: null,
        },
        profile: null,
    },
    mutations: {
        setOrganization (state, organizationId) {
            state.organization = organizationId;
        },
        setOauthToken (state, authInfo) {
            state.oauthToken = authInfo;
        },
        setUser (state, user) {
            state.auth.user = user;
        },
        setOauthInfo (state, oauthInfo) {
            state.oauthInfo = oauthInfo;
        },
        setProfile (state, profile) {
            state.profile = profile;
        },
        logout (state) {
            state.oauthToken = null;
            state.profile = null;
        },
    },
    actions: {
        findOrganization({state, commit}, domain) {

            // remove the organization
            if (domain === null) {
                commit('setOrganization', null);
            }

            // if the organization is not defined, get it from the api
            if (state.organization === null) {
                api.organizationByDomain(domain).then(response => {
                    commit('setOrganization', response.data)
                });
            }
            // else, do nothing
        },
        loadProfile({commit}) {
            api.profile().then(response => {
                commit('setProfile', response.data);
            });
        }
    },
    getters: {
        isLogged: state => state.oauthToken !== null,
        logo: state => state.organization ? (state.organization.logo || '/wflow_logo.png') : '/wflow_logo.png',
        user: state => state.profile ? state.profile : null,
        avatar: state => (state.profile && state.profile.avatar) ? `${state.profile.avatar}?token=${state.oauthToken.access_token}` : null,
        organizations: state => state.profile ? state.profile.organizations : [],
    },
    plugins: [vuexLocal.plugin],
});

export default store;