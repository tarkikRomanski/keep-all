const Auth = {
    install(Vue, options) {
        Vue.mixin({
            mounted() {
                let middleware, redirect, target = '';

                if (this.$route.meta.middleware) {
                    middleware = this.$route.meta.middleware.type ? this.$route.meta.middleware.type : '';
                    redirect = this.$route.meta.middleware.redirect ? this.$route.meta.middleware.redirect : false;
                }

                switch (middleware) {
                    case 'visitor':
                        target = redirect ? redirect : 'home';
                        if(Vue.auth.isAuthenticated()) {
                            this.$router.push({name: target});
                        }
                        break;
                    default:
                        target = redirect ? redirect : 'login';
                        if(!Vue.auth.isAuthenticated()) {
                            this.$router.push({name: target});
                        }
                }


            }
        });

        Vue.auth = {
            setToken(token, expiration) {
                localStorage.setItem('token', token);
                localStorage.setItem('expiration', expiration);

                window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.getToken();
            },

            getToken() {
                let token = localStorage.getItem('token');
                let expiration = localStorage.getItem('expiration');

                if (!token || !expiration) {
                    return null;
                }

                if (Date.now() > parseInt(expiration)) {
                    this.destroyToken();
                    return null;
                }

                return token;
            },

            destroyToken() {
                localStorage.removeItem('token');
                localStorage.removeItem('expiration');
            },

            isAuthenticated() {
                return this.getToken() ? true : false;
            }
        };

        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + Vue.auth.getToken();


        Object.defineProperties(Vue.prototype, {
            $auth: {
                get() {
                    return Vue.auth;
                }
            }
        });
    }
};

export default Auth;