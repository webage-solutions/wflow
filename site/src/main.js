import Vue from 'vue'
import App from './App.vue'
import router from './router.js'
import store from './store.js'
import 'bootstrap'
import api from "./plugins/api"
import vuetify from './plugins/vuetify';

// css
import './colors.css'
// import 'bootstrap/dist/css/bootstrap.css'
import '@fortawesome/fontawesome-free/css/all.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'

Vue.config.productionTip = false;

Vue.use(api);

new Vue({
  render: h => h(App),
  store,
  vuetify,
  router
}).$mount('#app');
