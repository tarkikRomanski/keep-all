<template>
    <div>
        <router-link :to="{ name: 'logout' }" v-show="$auth.getToken()">LogOut</router-link>
        <router-link :to="{ name: 'gists' }" v-show="$auth.getToken()">Gists</router-link>
        <router-view></router-view>
    </div>
</template>