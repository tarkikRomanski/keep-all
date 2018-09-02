<template>
    <div>
        <b-nav>
            <b-nav-item>
                <router-link :to="{ name: 'logout' }" 
                    v-show="$auth.getToken()">
                    LogOut
                </router-link>
            </b-nav-item>
            <b-nav-item>
                <router-link :to="{ name: 'gists.list' }"
                    v-show="$auth.getToken()">
                    Gists
                </router-link>
            </b-nav-item>
            <b-nav-item>
                <router-link :to="{ name: 'gists.create' }" 
                    v-show="$auth.getToken()">
                    Create Gists
                </router-link>
            </b-nav-item>
        </b-nav>
        <router-view></router-view>
    </div>
</template>

<script>
    import gql from 'graphql-tag';

    export default {
        created() {
            this.$apollo.query({
                query: gql` {
                    folders(onlyRoot: false) {
                        id
                        name
                    }
                }
                `
            }).then(response => {
                this.$store.dispatch('loadFolders', response.data.folders)
                    .then(response => console.info('folders loaded'));
            });
        }
    }
</script>