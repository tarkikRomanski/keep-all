<template>
    <div>
        <router-link :to="{ name: 'logout' }" v-show="$auth.getToken()">LogOut</router-link>
        <transition name="slide">
            <router-view></router-view>
        </transition>
    </div>
</template>

<style scoped>
    .slide-enter { transform: translateX(250%) }
    .slide-enter-to { transform: translateX(0) }
    .slide-enter-active { position: absolute }
    .slide-leave { transform: translateX(0) }
    .slide-leave-to { transform: translateX(-250%) }
    .slide-leave-active { position: absolute }
    .slide-enter-active { transition-delay: 300ms; }
    .slide-enter-active,
    .slide-leave-active {
        transition-property: all;
        transition-duration: 750ms;
        transition-timing-function: ease-in-out;
    }
</style>