import Vue from 'vue';
import Router from 'vue-router';
import Home from './components/views/Home';
import Error404 from "./components/errors/Error404";
import Error403 from "./components/errors/Error403";
import Login from "./components/views/Login";
import WorkflowEditor from "./components/views/WorkflowEditor";
import IndexOrganization from "./components/views/organizations/IndexOrganization";
import CreateOrganization from "./components/views/organizations/CreateOrganization";
import store from './store';
import SelectOrganization from "./components/views/SelectOrganization";
import randomstring from "randomstring";
import CryptoJs from 'crypto-js';
import LoadingMessage from "./components/views/LoadingMessage";
import axios from "axios";
import OAuthCallback from "./components/views/OAuthCallback";

Vue.use(Router);

// find organization domain
const baseDomain = process.env.VUE_APP_BASE_DOMAIN;
const currentDomain = window.location.hostname;
const regex = new RegExp(`([a-z][a-z0-9-]{3,})\\.${baseDomain}$`);

const matches = currentDomain.match(regex);

if (matches) {
    store.dispatch('findOrganization', matches[1]);
} else {
    store.commit('setOrganization', null);
}

// ------------------------

const globalRoutes = [
    {
        path: '/oauth-callback',
        meta: {
            layout: "compact-layout",
            guestAllowed: true,
        },
        component: OAuthCallback,
        props: {
            message: 'Signing in...'
        }
    },
    {
        path: '/preparing-signup',
        meta: {
            layout: "compact-layout",
            guestAllowed: true,
        },
        component: LoadingMessage,
        props: {
            message: 'Preparing sign in...'
        }
    },
    {
        path: '/select-organization',
        name: 'select-organization',
        title: 'Select Organization',
        meta: {
            layout: "compact-layout",
        },
        // beforeEnter: (to, from, next) => {
        //     if (store.state.auth.user.organizations.length === 1) {
        //         window.location = store.getters.autoLoggedLink(store.state.auth.user.organizations[0].domain);
        //     }
        //     next();
        // },
        component: SelectOrganization,
    },
    {
        path: '*',
        redirect: '/select-organization'
    },
];
const routes = [
    {
        path: '/',
        name: 'home',
        title: 'Home',
        component: Home,
    },
    {
        path: '/login',
        name: 'login',
        title: 'Login',
        meta: {
            layout: 'compact_layout',
            guestAllowed: true,
        },
        beforeEnter: (to, from, next) => {
            // logged users can't access login page. Go home.
            if (store.getters.isLogged) {
                next('/');
            }
            next();
        },
        component: Login,
    },
    {
        path: '/organizations/index',
        name: 'organizations.index',
        title: 'Organizations',
        component: IndexOrganization,
    },
    {
        path: '/organizations/create',
        name: 'organizations.create',
        title: 'Organizations',
        component: CreateOrganization,
    },
    {
        path: '/wflow-editor',
        name: 'wflow-editor',
        title: 'Workflow Editor',
        component: WorkflowEditor,
    },
    {
        path: '/forbidden',
        name: '403',
        title: '403',
        meta: {
            layout: "no-layout"
        },
        component: Error403,
    },
    {
        path: '*',
        name: '404',
        title: '404',
        meta: {
            layout: "no-layout",
            guestAllowed: true,
        },
        component: Error404,
    },
];

const router = new Router({
    mode: 'history',
    base: '/',
    routes: store.state.organization !== null ? routes : globalRoutes,
});

router.beforeEach((to, from, next) => {
    // login required and not logged, go to login
    if (!to.meta.guestAllowed && !store.getters.isLogged) {
        const state = randomstring.generate();
        const codeVerifier = randomstring.generate(128);
        store.commit('setOauthState', state);
        store.commit('setOauthCodeVerifier', codeVerifier);
        const codeChallenge = CryptoJs.SHA256(codeVerifier).toString(CryptoJs.enc.Base64).replace(/=/g, '').replace(/\+/g, '-').replace(/\//g, '_');
        const queryData = {
            client_id: 1,
            redirect_uri: 'http://localhost:8080/oauth-callback',
            response_type: 'code',
            scope: '*',
            state: state,
            code_challenge: codeChallenge,
            code_challenge_method: 'S256',
        };
        const query = Object.keys(queryData).map(key => `${key}=${encodeURI(queryData[key])}`).join('&');
        const url = `http://localhost/oauth/authorize?${query}`;
        window.location.replace(url);
        next('/preparing-signup');
    }

    next();
});



export default router;