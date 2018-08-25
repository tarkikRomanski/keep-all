<template>
    <b-card class="col-md-8 offset-md-2">
        <form id="loginForm" @submit.prevent="register">
            <h1>Registration</h1>
            <b-form-group label="Your name" label-for="user_name">
                <b-form-input id="user_name" type="text" v-model.trim="user.name"></b-form-input>
            </b-form-group>

            <b-form-group label="Your GitHub nickname" label-for="user_git_name">
                <b-form-input id="user_git_name" type="text" v-model.trim="user.git_username"></b-form-input>
            </b-form-group>

            <b-form-group label="Your access token from Github.com" label-for="user_access_token">
                <b-form-input id="user_access_token" type="text" v-model.trim="user.access_token"></b-form-input>
            </b-form-group>

            <b-form-group label="Your email" label-for="user_email">
                <b-form-input id="user_email" type="email" v-model.trim="user.email"></b-form-input>
            </b-form-group>

            <b-form-group label="Your password" label-for="user_password">
                <b-form-input id="user_password" type="password" v-model.trim="user.password"></b-form-input>
            </b-form-group>

            <b-button type="submit" variant="success">Registration</b-button>
        </form>
    </b-card>
</template>

<script>
    export default {
        data() {
            return {
                user: {
                    name: null,
                    email: null,
                    password: null,
                    git_username: null,
                    access_token: null
                },
                errors: {}
            }
        },

        methods: {
            register() {
                axios.post('api/1.0/register', this.user)
                    .then(response => {
                        console.log(response);
                        this.$auth.setToken(response.data.access_token, response.data.expires_in + Date.now());
                        this.$router.push({name: 'home'});
                    })
                    .catch(({response}) => {
                        switch (response.status) {
                            case 400:
                                this.$swal(
                                    'Registration error!',
                                    'You are have a problem with registration new data',
                                    'error'
                                );
                                console.error('Registration error');
                                this.errors = response.data;
                            break;
                        }
                    });
            }
        }
    }
</script>