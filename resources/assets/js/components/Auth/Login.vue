<template>
    <div class="row">
        <b-card class="col-md-8 offset-md-2">
            <form id="loginForm" @submit.prevent="login">
                <h1>Login</h1>
                <b-form-group label="Your email" label-for="user_email">
                    <b-form-input id="user_email" type="email" v-model.trim="user.email"></b-form-input>
                </b-form-group>

                <b-form-group label="Your password" label-for="user_password">
                    <b-form-input id="user_password" type="password" v-model.trim="user.password"></b-form-input>
                </b-form-group>

                <b-button type="submit" variant="success">Login</b-button>
                <router-link :to="{name:'registration'}">Do you haven't account?</router-link>
            </form>
        </b-card>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: {
                    email: null,
                    password: null
                }
            }
        },
        methods: {
            login() {
                let data = {
                    client_id: 2,
                    client_secret: 'eSYmGvfNdSuOXQsuZ0NuqEwrHRmt4aJ31WKHrz90',
                    grant_type: 'password',
                    username: this.user.email,
                    password: this.user.password
                };
                axios.post('oauth/token', data)
                    .then(response => {
                        this.$auth.setToken(response.data.access_token, response.data.expires_in + Date.now());
                        this.$router.push({name: 'home'});
                    })
                    .catch(({response}) => {
                        if (response.status == 401) {
                            this.$swal(
                                'Authentication error!',
                                'You are have a problem with authentication data',
                                'error'
                            );
                        }
                    });
            }
        }
    }
</script>