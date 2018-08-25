import Vue from 'vue';
import VueRouter from 'vue-router';

// custom components
import Login from './components/Auth/Login';
import Logout from './components/Auth/Logout';
import Registration from './components/Auth/Registration';
import Home from './components/Home';
//

// routes
//

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                middleware: {
                    type: 'visitor'
                }
            }
        },
        {
            path: '/registration',
            name: 'registration',
            component: Registration,
            meta: {
                middleware: {
                    type: 'visitor'
                }
            }
        },
        {
            path: '/logout',
            name: 'logout',
            component: Logout
        },
        {
            path: '/',
            name: 'home',
            component: Home
        },
    ],


});

export default router;