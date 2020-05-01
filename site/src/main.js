import Vue from 'vue';
import App from './App.vue';
import router from './router.js';
import store from './store.js';
import api from './api.js';
import 'bootstrap';
import vuetify from './plugins/vuetify';

// css
import './colors.css'
// import 'bootstrap/dist/css/bootstrap.css'
import '@fortawesome/fontawesome-free/css/all.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'

Vue.config.productionTip = false;

new Vue({
  render: h => h(App),
  store,
  vuetify,
  api,
  router
}).$mount('#app');
