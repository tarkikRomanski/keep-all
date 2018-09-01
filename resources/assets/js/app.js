require('./bootstrap');

window.Vue = require('vue');

Vue.mixin({
    methods: {
        humanFileSize(bytes) {
            var step = 1000;
            if(Math.abs(bytes) < step) {
                return bytes + ' B';
            }
            var units = ['kB','MB','GB','TB','PB','EB','ZB','YB'];
            var unit = -1;
            do {
                bytes /= step;
                ++unit;
            } while(Math.abs(bytes) >= step && unit < units.length - 1);
            return `${bytes.toFixed(1)} ${units[unit]}`;
        }
    }
});

/**
 * Start include Code Mirror
 */
import CodeMirror from 'vue-codemirror';
import 'codemirror/lib/codemirror.css'
Vue.use(CodeMirror, {
    options: {
        theme: 'base16-dark',
        lineNumbers: true,
        line: true,
    }
});
/**
 * End include Code Mirror
 */

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
 * Start include additional staff
 */
import router from './routes';
import store from './store';
import apolloProvider from './apollo';
/**
 * End include additional staff
 */

Vue.component('app', require('./components/App'));

const app = new Vue({
    el: '#app',
    provide: apolloProvider.provide(),
    router,
    store
});
