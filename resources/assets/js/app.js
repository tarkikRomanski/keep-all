require('./bootstrap');

window.Vue = require('vue');

/**
 * Start include BootstrapVue
 */
import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);
/**
 * End include BootstrapVue
 */

/**
 * Start include Sweet Alert
 */
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);
/**
 * End include Sweet Alert
 */

import Auth from './packages/auth';
Vue.use(Auth);

/**
 * Start routers include
 */
import Router from './routes.js';
/**
 * End routers include
 */

Vue.component('app', require('./components/App'));

const app = new Vue({
    el: '#app',
    router: Router
});
