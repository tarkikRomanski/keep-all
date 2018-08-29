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
                <router-link :to="{ name: 'gists' }" 
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