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
import LoadingMessage from "./components/views/LoadingMessage";
import OAuthCallback from "./components/views/OAuthCallback";
import api from "./api";

Vue.use(Router);

// ------------------------

// routes shared between root app and organization app
const sharedRoutes = [
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
        path: '/forbidden',
        name: '403',
        title: '403',
        meta: {
            layout: "compact-layout",
            guestAllowed: true,
        },
        component: Error403,
    },
    {
        path: '*',
        name: '404',
        title: '404',
        meta: {
            layout: "compact-layout",
            guestAllowed: true,
        },
        component: Error404,
    },
];

// routes used only on root app
const rootRoutes = [
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

// routes used only on organization app
const organizationRoutes = [
    {
        path: '/',
        name: 'home',
        title: 'Home',
        component: Home,
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
];

const router = new Router({
    mode: 'history',
    base: '/',
    routes: store.state.organization !== null ? [...organizationRoutes, ...sharedRoutes] : [...rootRoutes, ...sharedRoutes],
});

router.beforeEach((to, from, next) => {

    // login required and not logged, do the login process
    if (!to.meta.guestAllowed && !store.getters.isLogged) {
        api.authorizeLogin();
        next('/preparing-signup');
    }

    next();
});



export default router;